<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi Mahasiswa</title>

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
<body class="A4">
@php
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
@endphp
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
            LAPORAN E-PRESENSI MAHASISWA<br>
            PERIODE {{ $nama_bulan[$bulan] }} TAHUN {{ $tahun }}<br>
            POLITEKNIK NEGERI SEMARANG<br>
          </span>
          <span><i>Jl. Prof. Sudarto, Tembalang, Kec. Tembalang, Kota Semarang, Jawa Tengah 50275</i></span>
        </td>
      </tr>
    </table>
    <table class="tabeldatakaryawan">
      <tr>
        <td rowspan="6">
          @php
              $path = Storage::url('upload/mahasiswa/'.$mahasiswa->foto); 
          @endphp
          <img src="{{ url($path) }}" width="150" height="200" alt="">
        </td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>:</td>
        <td>{{ $mahasiswa->nim }}</td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{ $mahasiswa->nama_lengkap }}</td>
      </tr>
      <tr>
        <td>Kelas</td>
        <td>:</td>
        <td>{{ $mahasiswa->kelas }}</td>
      </tr>
      <tr>
        <td>Program Studi</td>
        <td>:</td>
        <td>{{ $mahasiswa->nama_prodi }}</td>
      </tr>
      <tr>
        <td>No.HP</td>
        <td>:</td>
        <td>{{ $mahasiswa->no_hp }}</td>
      </tr>
    </table>
    <table class="tabelpresensi">
      <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Foto</th>
        <th>Jam Pulang</th>
        <th>Foto</th>
        <th>Keterangan</th>
        <th>Jumlah Jam</th>
      </tr>
        @foreach ($presensi as $d)
            @php
              $path_in = Storage::url('public/upload/absensi'.$d->foto_in); 
              $path_out = Storage::url('public/upload/absensi'.$d->foto_out);
              $jam_terlambat = selisih('07:00:00', $d->jam_in);
            @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
            <td>{{ $d->jam_in }}</td>
            <td> <img src="{{ url($path_in) }}" alt="" class="foto"></td>
            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
            <td> 
              @if ($d->jam_out != null)
              <img src="{{ url($path_out) }}" alt="" class="foto">
              @else
              Foto tidak tersedia
              @endif
            </td>
            <td>
              @if ($d->jam_in > '07:00')
                Terlambat {{ $jam_terlambat }}
              @else
                Tepat waktu
              @endif
            </td>
            <td>
              @if ($d->jam_out != null)
              @php
                  $jml_jam = selisih($d->jam_in, $d->jam_out);
              @endphp
              @else
              @php
                  $jml_jam = 0;
              @endphp
              @endif
              {{ $jml_jam }}
            </td>
        </tr>
        @endforeach
    </table>

    <table width= "100%" style="margin-top: 100px">
      <tr>
        <td colspan="2" style="text-align: right">Semarang, {{ date('d-m-Y') }}</td>
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