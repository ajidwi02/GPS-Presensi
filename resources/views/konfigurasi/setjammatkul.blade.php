@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Setting
        </div>
        <h2 class="page-title">
          JAM MATA KULIAH
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-12">
        <table class="table">
          <tr>
            <th>NIM</th>
            <td>{{ $mahasiswa->nim }}</td>
          </tr>
          <tr>
            <th>Nama Mahasiswa</th>
            <th>{{ $mahasiswa->nama_lengkap }}</th>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <form action="/konfigurasi/storesetjammatkul" method="POST">
          @csrf
          <input type="hidden" name="nim" value="{{ $mahasiswa->nim }}">
          <table class="table">
            <thead>
              <tr>
                <th>Hari</th>
                <th>Jam Mata Kuliah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Senin</td>
                <input type="hidden" name="hari[]" value="senin">
                <td>
                  <select name="kode_jam_matkul[]" id="kode_jam_matkul" class="form-select">
                    <option value="">Pilih Jam Matkul</option>
                    @foreach ($jammatkul as $d)
                        <option value="{{ $d->kode_jam_matkul }}" >{{ $d->nama_jam_matkul }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Selasa</td>
                <input type="hidden" name="hari[]" value="selasa">
                <td>
                  <select name="kode_jam_matkul[]" id="kode_jam_matkul" class="form-select">
                    <option value="">Pilih Jam Matkul</option>
                    @foreach ($jammatkul as $d)
                        <option value="{{ $d->kode_jam_matkul }}" >{{ $d->nama_jam_matkul }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Rabu</td>
                <input type="hidden" name="hari[]" value="rabu">
                <td>
                  <select name="kode_jam_matkul[]" id="kode_jam_matkul" class="form-select">
                    <option value="">Pilih Jam Matkul</option>
                    @foreach ($jammatkul as $d)
                        <option value="{{ $d->kode_jam_matkul }}" >{{ $d->nama_jam_matkul }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Kamis</td>
                <input type="hidden" name="hari[]" value="kamis">
                <td>
                  <select name="kode_jam_matkul[]" id="kode_jam_matkul" class="form-select">
                    <option value="">Pilih Jam Matkul</option>
                    @foreach ($jammatkul as $d)
                        <option value="{{ $d->kode_jam_matkul }}" >{{ $d->nama_jam_matkul }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Jum'at</td>
                <input type="hidden" name="hari[]" value="jumat">
                <td>
                  <select name="kode_jam_matkul[]" id="kode_jam_matkul" class="form-select">
                    <option value="">Pilih Jam Matkul</option>
                    @foreach ($jammatkul as $d)
                        <option value="{{ $d->kode_jam_matkul }}" >{{ $d->nama_jam_matkul }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
          <button class="btn btn-success w-100" type="submit">Simpan</button>
        </form>
      </div>
      <div class="col-6">
        <table class="table">
          <thead>
            <tr>
              <th colspan="6" >Master Jam Mata Kuliah</th>
            </tr>
            <tr>
              <th>Kode</th>
              <th>Dosen Pengampu</th>
              <th>Awal</th>
              <th>Jam Masuk</th>
              <th>Akhir Masuk</th>
              <th>Jam Pulang</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jammatkul as $d)
                <tr>
                  <td>{{$d->kode_jam_matkul}}</td>
                  <td>{{$d->keterangan}}</td>
                  <td>{{$d->awal_jam_masuk}}</td>
                  <td>{{$d->jam_masuk}}</td>
                  <td>{{$d->akhir_jam_masuk}}</td>
                  <td>{{$d->jam_pulang}}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection