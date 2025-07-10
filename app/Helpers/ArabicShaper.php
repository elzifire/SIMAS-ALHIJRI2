<?php

namespace App\Helpers;

/**
 * A PHP class for reshaping Arabic text.
 * Based on the logic from multiple open-source projects for compatibility with dompdf.
 */
class ArabicShaper
{
    /**
     * The main function to reshape Arabic text.
     *
     * @param string $text The text to reshape.
     * @return string The reshaped text.
     */
    public function shape(string $text): string
    {
        $lines = explode("\n", $text);
        $reshapedLines = [];
        foreach ($lines as $line) {
            $reshapedLines[] = $this->reshapeLine($line);
        }
        return implode("\n", $reshapedLines);
    }

    private function reshapeLine($line)
    {
        $reshapedLine = '';
        $arabicWord = '';
        $nonArabicWord = '';

        for ($i = 0; $i < mb_strlen($line, 'UTF-8'); $i++) {
            $char = mb_substr($line, $i, 1, 'UTF-8');
            if ($this->isArabicChar($this->uniord($char))) {
                if (!empty($nonArabicWord)) {
                    $reshapedLine .= $nonArabicWord;
                    $nonArabicWord = '';
                }
                $arabicWord .= $char;
            } else {
                if (!empty($arabicWord)) {
                    $reshapedLine .= $this->processArabicWord($arabicWord);
                    $arabicWord = '';
                }
                $nonArabicWord .= $char;
            }
        }

        if (!empty($arabicWord)) {
            $reshapedLine .= $this->processArabicWord($arabicWord);
        } elseif (!empty($nonArabicWord)) {
            $reshapedLine .= $nonArabicWord;
        }

        return $reshapedLine;
    }

    private function processArabicWord($arabicWord)
    {
        $reshapedWord = '';
        $wordLen = mb_strlen($arabicWord, 'UTF-8');
        for ($j = 0; $j < $wordLen; $j++) {
            $char = mb_substr($arabicWord, $j, 1, 'UTF-8');
            $prevChar = ($j > 0) ? mb_substr($arabicWord, $j - 1, 1, 'UTF-8') : '';
            $nextChar = ($j < $wordLen - 1) ? mb_substr($arabicWord, $j + 1, 1, 'UTF-8') : '';
            
            $context = $this->getContext($char, $prevChar, $nextChar);
            
            $charOrd = $this->uniord($char);
            $nextCharOrd = $this->uniord($nextChar);

            if ($charOrd == 1604 && $this->isAlef($nextCharOrd)) {
                 $ligature = $this->getLigature($charOrd, $nextCharOrd, $this->connectsToNext($this->uniord($prevChar)));
                 if ($ligature !== null) {
                    $reshapedWord .= $this->unichr($ligature);
                    $j++; 
                    continue;
                 }
            }
            
            $reshapedWord .= $this->getReshapedGlyph($char, $context);
        }
        return $this->mbStrrev($reshapedWord, 'UTF-8');
    }

    private function getContext($char, $prevChar, $nextChar)
    {
        $charOrd = $this->uniord($char);
        $prevCharOrd = $this->uniord($prevChar);
        $nextCharOrd = $this->uniord($nextChar);

        $connectsAfter = $this->isArabicChar($nextCharOrd) && $this->connectsToNext($charOrd) && $this->connectsToPrev($nextCharOrd);
        $connectsBefore = $this->isArabicChar($prevCharOrd) && $this->connectsToNext($prevCharOrd);

        if ($connectsBefore && $connectsAfter) return 3; // Medial
        if (!$connectsBefore && $connectsAfter) return 2; // Initial
        if ($connectsBefore && !$connectsAfter) return 1; // Final
        return 0; // Isolated
    }
    
    private function connectsToNext($charOrd) {
        $nonConnecting = [1570, 1571, 1573, 1575, 1583, 1584, 1585, 1586, 1608, 1610];
        return $this->isArabicChar($charOrd) && !in_array($charOrd, $nonConnecting, true);
    }
    
    private function connectsToPrev($charOrd) {
        return $this->isArabicChar($charOrd);
    }

    private function getReshapedGlyph($char, $context)
    {
        $glyphs = $this->getGlyphs();
        $charOrd = $this->uniord($char);
        if (isset($glyphs[$charOrd])) {
            return $this->unichr($glyphs[$charOrd][$context]);
        }
        return $char;
    }
    
    private function getLigature($lamOrd, $alefOrd, $connectedBefore) {
        $ligatures = [
            1570 => [0xFEF5, 0xFEF6],
            1571 => [0xFEF7, 0xFEF8],
            1573 => [0xFEF9, 0xFEFA],
            1575 => [0xFEFB, 0xFEFC],
        ];

        if (isset($ligatures[$alefOrd])) {
            $form = $connectedBefore ? 1 : 0;
            return $ligatures[$alefOrd][$form];
        }
        return null;
    }
    
    private function uniord($c) {
        if(empty($c)) return 0;
        $h = ord($c[0]);
        if ($h <= 0x7F) return $h;
        if ($h < 0xC2) return false;
        if ($h <= 0xDF) return ($h & 0x1F) << 6 | (ord($c[1]) & 0x3F);
        if ($h <= 0xEF) return ($h & 0x0F) << 12 | (ord($c[1]) & 0x3F) << 6 | (ord($c[2]) & 0x3F);
        if ($h <= 0xF4) return ($h & 0x07) << 18 | (ord($c[1]) & 0x3F) << 12 | (ord($c[2]) & 0x3F) << 6 | (ord($c[3]) & 0x3F);
        return false;
    }

    private function unichr($i) {
        if ($i < 0x80) return chr($i);
        if ($i < 0x800) return chr(0xC0 | $i >> 6) . chr(0x80 | $i & 0x3F);
        if ($i < 0x10000) return chr(0xE0 | $i >> 12) . chr(0x80 | $i >> 6 & 0x3F) . chr(0x80 | $i & 0x3F);
        if ($i < 0x200000) return chr(0xF0 | $i >> 18) . chr(0x80 | $i >> 12 & 0x3F) . chr(0x80 | $i >> 6 & 0x3F) . chr(0x80 | $i & 0x3F);
        return false;
    }

    private function mbStrrev($str, $encoding='UTF-8'){
        return mb_convert_encoding(strrev(mb_convert_encoding($str, 'UTF-16BE', $encoding)), $encoding, 'UTF-16LE');
    }
    
    private function isAlef($charOrd){
        return in_array($charOrd, [1570, 1571, 1573, 1575], true);
    }

    private function isArabicChar($charOrd)
    {
        return ($charOrd >= 0x0600 && $charOrd <= 0x06FF) || ($charOrd >= 0xFE70 && $charOrd <= 0xFEFF);
    }

    private function getGlyphs() {
        return [
            1569=>[65152,65153,65153,65152],1570=>[65154,65155,65155,65154],1571=>[65156,65157,65157,65156],
            1572=>[65158,65159,65159,65158],1573=>[65160,65161,65161,65160],1574=>[65162,65163,65164,65165],
            1575=>[65166,65167,65167,65166],1576=>[65168,65169,65170,65171],1577=>[65172,65173,65173,65172],
            1578=>[65174,65175,65176,65177],1579=>[65178,65179,65180,65181],1580=>[65182,65183,65184,65185],
            1581=>[65186,65187,65188,65189],1582=>[65190,65191,65192,65193],1583=>[65194,65195,65195,65194],
            1584=>[65196,65197,65197,65196],1585=>[65198,65199,65199,65198],1586=>[65200,65201,65201,65200],
            1587=>[65202,65203,65204,65205],1588=>[65206,65207,65208,65209],1589=>[65210,65211,65212,65213],
            1590=>[65214,65215,65216,65217],1591=>[65218,65219,65220,65221],1592=>[65222,65223,65224,65225],
            1593=>[65226,65227,65228,65229],1594=>[65230,65231,65232,65233],1601=>[65234,65235,65236,65237],
            1602=>[65238,65239,65240,65241],1603=>[65242,65243,65244,65245],1604=>[65246,65247,65248,65249],
            1605=>[65250,65251,65252,65253],1606=>[65254,65255,65256,65257],1607=>[65258,65259,65260,65261],
            1608=>[65262,65263,65263,65262],1609=>[65264,65265,65266,65267],1610=>[65268,65269,65270,65271],
            1611=>[64481,64481,64481,64481],1612=>[64482,64482,64482,64482],1613=>[64483,64483,64483,64483],
            1614=>[64484,64484,64484,64484],1615=>[64485,64485,64485,64485],1616=>[64486,64486,64486,64486],
            1617=>[64487,64487,64487,64487],1618=>[64488,64488,64488,64488],
        ];
    }
}
