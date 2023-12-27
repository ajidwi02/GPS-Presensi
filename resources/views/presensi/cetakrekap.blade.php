<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Rekap Presensi</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page { 
      size: A4 
    }

    #title {
      font-size: 18px;
      font-weight: bold; 
    }

    .tabeldatakaryawan{
      margin-top: 40px;
      font-family: Arial, Helvetica, sans-serif;
    }

    .tabeldatakaryawan td{
      padding: 5px;
    }

    .tabelpresensi{
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    .tabelpresensi tr th{
      border: 1px solid black;
      padding: 8px;
      background: rgb(225, 223, 223);
      font-size: 10px;
    }
    .tabelpresensi tr td{
      border: 1px solid black;
      padding: 5px;
      font-size: 10px;
    }

    .foto{
      width: 70px;
      height: 70px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">
{{-- @php
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
      return $jml_jam . " jam " . round($sisamenit2) . " menit";
    }
@endphp --}}
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%" border: 1>
      <tr>
        <td style="width: 80px">
            <img src="{{ asset('assets/img/logo.png') }}" width="70" height="70" alt="">
        </td>
        <td>
          <span id="title">
            REKAP E-PRESENSI MAHASISWA<br>
            PERIODE {{ $nama_bulan[$bulan] }} TAHUN {{ $tahun }}<br>
            POLITEKNIK NEGERI SEMARANG<br>
          </span>
          <span><i>Jl. Prof. Sudarto, Tembalang, Kec. Tembalang, Kota Semarang, Jawa Tengah 50275</i></span>
        </td>
      </tr>
    </table>
    <table class="tabelpresensi">
      <tr>
        <th rowspan="2" >NIM</th>
        <th rowspan="2" >Nama Mahasiswa</th>
        <th colspan="31">Tanggal</th>
        <th rowspan="2">TH</th>
        <th rowspan="2">TT</th>
      </tr>
      <tr>
        <?php
          for($i=1; $i <= 31; $i++){
            ?>
          <th>{{ $i }}</th>
          <?php
        }
          ?>
      </tr>
      @foreach ($rekap as $d)
          <tr>
            <td>{{ $d->nim }}</td>
            <td>{{ $d->nama_lengkap }}</td>

            <?php
            $totalhadir = 0;
            $totalterlambat = 0;
              for($i=1; $i <= 31; $i++){
                $tgl = "tgl_". $i;

                $hadir = explode("-", $d->$tgl);
                if(empty($d->$tgl)){
                  $hadir = ['', ''];
                  $totalhadir += 0;

                } else {
                  $hadir = explode("-", $d->$tgl);
                  $totalhadir += 1;
                  if($hadir[0] > $d->jam_masuk){
                    $totalterlambat += 1;
                  } else {
                    $totalterlambat += 0;
                  }
                }
                ?>

              <td>
                <span style="color: {{ $hadir[0] > $d->jam_masuk ? "red" : "" }}">{{ !empty($hadir[0]) ? $hadir[0] : "-"}}</span><br>
                <span style="color: {{ $hadir[1] < $d->jam_pulang ? "red" : "" }}">{{ !empty($hadir[1]) ? $hadir[1] : "-"}}</span>
              </td>
              
              <?php
            }
              ?>
            <td>
              {{ $totalhadir }}
            </td>
            <td>
              {{ $totalterlambat }}
            </td>
          </tr>
      @endforeach
    </table>
    <table width= "100%" style="margin-top: 100px">
      <tr>
        <td></td>
        <td style="text-align: center">Semarang, {{ date('d-m-Y') }}</td>
      </tr>
      <tr>
        <td style="text-align: center; vertical-align: bottom;">
          <u>Prof. Dr. Totok Prasetyo, B.Eng (Hons), M.T., IPU, Asean.Eng, ACPE</u><br>
          <i><b>Direktur Politeknik Negeri Semarang</b></i>
        </td>
        <td style="text-align: center; vertical-align: bottom;" height="100px">
          <u>Seno Bayu Aji</u><br>
          <i><b>Staff PBM</b></i>
        </td>
      </tr>
    </table>
  </section>

</body>

</html>