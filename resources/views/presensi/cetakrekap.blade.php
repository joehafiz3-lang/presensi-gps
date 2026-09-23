<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabledatakaryawan {
            margin-top: 40px;
        }

        .tabledatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

        }

        .tabelpresensi tr th {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            bbackground-color: #f2f2f2;
            font-size: 9px;
        }

        .tabelpresensi tr td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
            font-size: 9px;
        }

        .tabel-ttd {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        list($h, $m, $s) = explode(":", $jam_masuk);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(":", $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ":" . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logopresensi.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="title">
                        REKAP PRESENSI MAGANG <br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PERWAKILAN BPKP SUMSEL <br>
                    </span>
                    <span><i>Jl. Tkr, Mat Tjik Rosad, Komplek Bank Raya No.2, Lorok Pakjo, Kec. Ilir Bar. I, Kota Palembang</i></span>
                </td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">Nik</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TT</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 31; $i++)
                    <th>{{ $i }}</th>
                    @endfor
            </tr>
            @foreach ($rekap as $d)
            <tr>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->nama_lengkap }}</td>

                <?php
                $totalhadir = 0;
                $totalterlambat = 0;
                for ($i = 1; $i <= 31; $i++) {
                    $tgl = "tgl_" . $i;
                    if (empty($d->$tgl)) {
                        $hadir = ['', ''];
                        $totalhadir += 0;
                    } else {
                        $hadir = explode('-', $d->$tgl);
                        $totalhadir += 1;
                        if ($hadir[0] > "08:00:00") {
                            $totalterlambat += 1;
                        }
                    }
                ?>
                    <td>
                        <span style="color: {{ $hadir[0]>"08:00:00" ? "red" : "" }}">{{ $hadir[0] }}</span><br>
                    </td>

                <?php
                }
                ?>
                <td>{{ $totalhadir }}</td>
                <td>{{ $totalterlambat }}</td>
            </tr>
            @endforeach
        </table>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td style="text-align: center">Palembang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u><b>Jauhari</b></u><br>
                    <i>Pembimbing</i>
                </td>
                <td style="text-align: center; vertical-align:bottom">
                    <u><b>Mufli Rumekso</b></u><br>
                    <i>Subkor Kepegawaian</i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>