@php
    // Memanggil dan menginisialisasi helper ArabicShaper
    require_once(app_path('Helpers/ArabicShaper.php'));
    $arabic = new \App\Helpers\ArabicShaper();
    
    $syahadatText = 'أَشْهَدُ أَنْ لَا إِلَهَ إِلَّا اللهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُوْلُ اللهِ';
    // Sekarang gunakan method 'shape' dari class yang baru
    $syahadatRender = $arabic->shape($syahadatText);
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Pernyataan Mualaf</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .header-text {
            text-align: center;
        }
        .header-text h3, .header-text h4, .header-text p {
            margin: 0;
        }
        .header-text p {
            font-size: 10pt;
        }
        .title {
            text-align: center;
            margin-top: 20px;
        }
        .title h4 {
            margin-bottom: 5px;
            text-decoration: underline;
            font-weight: bold;
        }
        .title p {
            margin-top: 0;
            font-size: 11pt;
        }
        .content-table {
            margin-top: 20px;
            width: 100%;
        }
        .content-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .content-table .label {
            width: 30%;
        }
        .content-table .separator {
            width: 5%;
            text-align: center;
        }
        .syahadat {
            font-family: 'DejaVu Sans', sans-serif; /* Tetap gunakan font yang mendukung Arab */
            font-size: 22pt;
            text-align: center;
            margin: 20px 0;
        }
        .syahadat-translation {
            text-align: center;
            font-style: italic;
            margin-bottom: 20px;
        }
        .signature-table {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }
        .signature-table td {
            width: 50%;
            padding-top: 70px;
        }
        .saksi-table {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }
        .saksi-table td {
            width: 50%;
        }
        .saksi-label {
            margin-bottom: 70px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td style="width: 15%; text-align: center;"></td>
                <td class="header-text">
                    <h3>DEWAN KEMAKMURAN MASJID (DKM) IBN KHALDUN</h3>
                    <h4>Universitas Ibn Khaldun Bogor</h4>
                    <p>
                        Sekretariat: Masjid Al-Hijri II Kampus UIKA Bogor, Jln. KH. Sholeh Iskandar Km.2, Kedung Badak, Tanah Sareal, Kota Bogor, 16162
                        <br>
                        Tlp/Wa: 0857-1780-4786
                    </p>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>

        <div class="title">
            <h4>SURAT PERNYATAAN MUALAF (MASUK AGAMA ISLAM)</h4>
            <p>No: {{ $nomor_surat ?? '_____________________' }}</p>
        </div>

        <p>Pada hari ini {{ $pendaftaran->created_at ? \Carbon\Carbon::parse($pendaftaran->created_at)->isoFormat('dddd, D MMMM YYYY') : '....................' }}, telah menghadap kepada kami seorang Laki-laki/Perempuan dengan identitas sebagai berikut:</p>

        <table class="content-table">
             <tr>
                <td class="label">Nama</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat dan Tanggal Lahir</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->tmptlahir ?? '-' }}, {{ $pendaftaran->birthdate ? \Carbon\Carbon::parse($pendaftaran->birthdate)->isoFormat('D MMMM YYYY') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="separator">:</td>
                <td>{{ $pendaftaran->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Agama Sebelumnya</td>
                <td class="separator">:</td>
                <td>{{ ucfirst($pendaftaran->agama ?? '-') }}</td>
            </tr>
        </table>

        <p>Menyatakan dengan sesungguhnya bahwa:</p>
        <ol type="a" style="padding-left: 20px;">
            <li>Atas kesadaran dan kemauan sendiri serta tidakn ada paksaan dari orang lain.</li>
            <li>Dalam keadaan sehat jasmani, rohani serta dengan keikhlasan hati yang tulus dan penuh keyakinan. Dengan ini menyatakan berikrar:</li>
        </ol>

        <div class="syahadat">
            {{ $syahadatRender }}
        </div>
        <div class="syahadat-translation">
            "ASYHADU AN LAA ILAAHA ILLA ALLAH, WA ASYHADU ANNA MUHAMMADAN RASUULULLAH"
        </div>
        <p style="text-align: center; padding: 0 40px;"><i>"Aku bersaksi bahwa tidak ada Tuhan yang berhak disembah selain Allah, dan aku bersaksi bahwa Nabi Muhammad itu utusan Allah"</i></p>
        
        <p>Dengan pernyataan ikrar ini, maka mulai saat surat ini dikeluarkan maka yang bersangkutan telah SAH MENJADI PEMELUK AGAMA ISLAM dan telah meninggalkan segala bentuk kepercayaan agama yang dianut sebelumnya.</p>
        <p>Jika terdapat penyimpangan atau penyalahgunaan atas surat ini, harap berkoordinasi dengan kami untuk diadakan evaluasi dan tindakan sebagaimana mestinya.</p>
        
        <p style="text-align: right; margin-right: 80px;">Bogor, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>

        <table class="signature-table">
            <tr>
                <td>Pembimbing Syahadat</td>
                <td>Yang Bersangkutan</td>
            </tr>
            <tr>
                <td><u>{{ $pendaftaran->nama_pembimbing_ikrar ?? '(..........................................)' }}</u></td>
                <td><u>{{ $pendaftaran->name ?? '(..........................................)' }}</u></td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 50px;">Saksi - Saksi</div>
        <table class="saksi-table">
            <tr>
                <td class="saksi-label">1. ( {{ $pendaftaran->saksi->saksi_name ?? '....................' }} )</td>
                <td class="saksi-label">DKM Masjid Ibn Khaldun UIKA</td>
            </tr>
            <tr>
                <td class="saksi-label">2. ( {{ $pendaftaran->saksi->saksi_name2 ?? '....................' }} )</td>
                <td style="padding-top: 70px;"><u>{{ $nama_ketua_dkm ?? '(..........................................)' }}</u></td>
            </tr>
        </table>
    </div>
</body>
</html>
