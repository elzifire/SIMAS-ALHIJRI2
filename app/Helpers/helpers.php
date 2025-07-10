<?php
use Illuminate\Support\Facades\Request;

if (!function_exists('setActive')) {
    /**
     * setActive
     *
     * @param  mixed $path
     * @return string
     */
    function setActive($path)
    {
        if (is_array($path)) {
            foreach ($path as $route) {
                if (Request::is($route . '*')) {
                    return ' active';
                }
            }
            return '';
        }
        return Request::is($path . '*') ? ' active' : '';
    }
}

if (! function_exists('TanggalID')) {         
    
    /**
     * TanggalID
     *
     * @param  mixed $tanggal
     * @return void
     */
    function TanggalID($tanggal) {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}