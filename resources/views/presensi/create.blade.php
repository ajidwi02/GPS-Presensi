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
      <input type="hidden" id="lokasi">
      <div class="webcam-capture"></div>
    </div>
  </div>
  <div class="jam-digital-malasngoding">
    <p> {{ date("d-m-Y") }}</p>
    <p class="" id="jam"></p><br>
    <p>{{ $jam_matkul->nama_jam_matkul }} ({{ date("H:i", strtotime($jam_matkul->jam_masuk)) }}) - {{ $jam_matkul->keterangan }}</p>
    <br>
    <p>Absen Masuk: <br> {{ date("H:i", strtotime($jam_matkul->awal_jam_masuk)) }} - {{ date("H:i", strtotime($jam_matkul->akhir_jam_masuk)) }}</p><br>
    <p>Absen Pulang: <br> {{ date("H:i", strtotime($jam_matkul->jam_pulang)) }}</p>
  </div>
  <div class="row">
    <div class="col">
      @if ($cek > 0)
        <button id="takeabsen" class="btn btn-block" style="background-color: #1b283b; color: white"><ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>   
      @else 
      <button id="takeabsen" class="btn btn-block" style="background-color: #1b283b; color: white"><ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>   
      @endif
    </div>
  </div>
  <div class="row mt-2">
    <div class="col">
      <div id="map"></div>
    </div>
  </div>

  <audio id="notifikasi_in">
    <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
  </audio>

  <audio id="notifikasi_out">
    <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
  </audio>

  <audio id="radius_sound">
    <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
  </audio>
@endsection

@push('myscript')
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }
    
        function jam() {
            var e = document.getElementById('jam')
                , d = new Date()
                , h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());
    
            e.innerHTML = h + ':' + m + ':' + s;
    
            setTimeout('jam()', 1000);
        }
    
        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>

    <script>

      var notifikasi_in = document.getElementById('notifikasi_in');
      var notifikasi_out = document.getElementById('notifikasi_out');
      var radius_sound = document.getElementById('radius_sound');

      Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
      });

      Webcam.attach('.webcam-capture');
      var lokasi = document.getElementById('lokasi');
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
      }

      function successCallback(position){
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
        var lokKampus = "{{ $lokasiKampus->lokasi_kampus }}";
        var getlok = lokKampus.split(",");
        var lat_kampus = getlok[0];
        var long_kampus = getlok[1];
        var radius = "{{ $lokasiKampus->radius }}"
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

        //Lokasi Kampus
        var circle = L.circle([lat_kampus, long_kampus], {
          color: 'red',
          fillColor: '#f03',
          fillOpacity: 0.5,
          radius: radius
        }).addTo(map);
      }

      function errorCallback(){

      }

      $("#takeabsen").click(function(e) {
        Webcam.snap(function(uri) {
          image = uri;
        });
        var lokasi = $("#lokasi").val();
        $.ajax({
          type: 'POST',
          url: '/presensi/store',
          data:{
            _token:"{{ csrf_token() }}",
            image:image,
            lokasi:lokasi
          },
          cache:false,
          success:function(respond){
            var status = respond.split("|");
            if(status[0] == "success"){
              if(status[2] == "in"){
                notifikasi_in.play();
              } else {
                notifikasi_out.play();
              }
              Swal.fire({
                title: 'Berhasil',
                text: status[1],
                icon: 'success'
              });
              setTimeout("location='/dashboard'", 3000);
            } else {
              if(status[2] == "radius"){
                radius_sound.play();
              }
              Swal.fire({
                title: 'Gagal',
                text: status[1],
                icon: 'error',
                confirmButtonText: 'OK'
              });
              setTimeout("location='/dashboard'", 3000);
            }
          }
        })
      });
    </script>
@endpush