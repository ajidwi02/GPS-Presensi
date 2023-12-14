@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Data
        </div>
        <h2 class="page-title">
          Laporan Presensi
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <form action="/presensi/cetaklaporan" target="_blank" method="POST" class="">
              @csrf
              <div class="row mt-2">
                <div class="col-12">
                  <div class="form-group">
                    <select name="bulan" id="bulan" class="form-select">
                      <option value="">Bulan</option>
                      @for ($i = 1; $i < 13; $i++)
                      <option value="{{ $i }}" {{date("m") == $i ? 'selected' : '' }}>{{ $nama_bulan[$i] }}</option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <div class="form-group">
                    <select name="tahun" id="tahun" class="form-select">
                      <option value="">Tahun</option>
                      @php
                      $tahunmulai = 2022;
                      $tahunskrg = date("Y");
                      @endphp
                      @for ($tahun=$tahunmulai; $tahun <= $tahunskrg; $tahun++)
                      <option value="{{ $tahun }}" {{date("Y") == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <div class="form-group">
                    <select name="nim" id="nim" class="form-select">
                      <option value="">Pilih Karyawan</option>
                      @foreach ($mahasiswa as $d)
                          <option value="{{ $d->nim }}">{{ $d->nama_lengkap}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-6">
                  <div class="form-group">
                    <button class="btn btn-primary w-100" name="cetak" type="submit">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                      Cetak
                    </button>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <button class="btn btn-success w-100" name="exportexcel" type="submit">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-csv" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M7 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" /><path d="M10 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" /><path d="M16 15l2 6l2 -6" /></svg>
                      Export
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection