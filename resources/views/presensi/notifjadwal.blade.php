@extends('layouts.presensi')
@section('header')
  <!-- App Header -->
  <div class="appHeader text-light" style="background-color: #1b283b">
      <div class="left">
          <a href="javascript:;" class="headerButton goBack">
              <ion-icon name="chevron-back-outline"></ion-icon>
          </a>
      </div>
      <div class="pageTitle">E-Presensi</div>
      <div class="right"></div>
  </div>
  <!-- * App Header -->
  <style>
    .webcam-capture,
    .webcam-capture video {
      width: 100% !important;
      display: inline-block;
      margin: auto;
      height: auto !important;
      border-radius: 15px;
    }

    #map { 
      height: 200px; 
    }

    .jam-digital-malasngoding {
      background-color: #27272783;
      position: absolute;
      top: 65px;
      right: 15px;
      z-index: 9999;
      width: 150px;
      border-radius: 10px;
      padding: 5px;
    }

    .jam-digital-malasngoding p {
      color: #fff;
      font-size: 13px;
      text-align: right;
      margin-top: 0;
      margin-bottom: 0;
    }
  </style>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>  
@endsection
@section('content')
  <div class="row" style="margin-top: 60px">
    <div class="col">
      <div class="alert alert-warning">
        <p>
          Maaf, anda tidak memiliki jadwal absen untuk hari ini!, Silahkan hubungi staff PBM
        </p>
      </div>
    </div>
  </div>

@endsection
