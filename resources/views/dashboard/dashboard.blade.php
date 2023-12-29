@extends('layouts.presensi')
@section('content')

<style>
    #user-section{
        background-color: #1b283b !important;
    }

    .logout{
        position: absolute;
        color: white;
        font-size: 25px;
        right: 15px;
    }

    .logout:hover{
        color: white;
    }
    
</style>
<div id="appCapsule">
    <div class="section" id="user-section">
        <a href="/proseslogout" class="logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
        </a>
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('mahasiswa')->user()->foto))
                @php
                    $path = Storage::url('upload/mahasiswa/'. Auth::guard('mahasiswa')->user()->foto);
                @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded" style="height: 60px">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h3 id="user-name">{{Auth::guard('mahasiswa')->user()->nama_lengkap}}</h3>
                <span id="user-role">{{Auth::guard('mahasiswa')->user()->kelas}}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/histori" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card" style="background-color: #1b283b">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('public/upload/absensi' . $presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span style="color: white">{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="background-color: #1b283b">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('public/upload/absensi' .$presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span style="color: white">{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="rekappresensi">
            <h3>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                        <span class="badge bg-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.8rem; z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                        <ion-icon name="calendar-clear-outline" style="font-size: 2.5rem;" class="text-primary mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem; font-weight: 500">Hadir</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                        <span class="badge bg-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.8rem; z-index:999">{{$rekapizin->jml_izin}}</span>
                        <ion-icon name="newspaper-outline" style="font-size: 2.5rem;" class="text-success mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem; font-weight: 500">Izin</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                        <span class="badge bg-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.8rem; z-index:999">{{$rekapizin->jml_sakit}}</span>
                        <ion-icon name="medkit-outline" style="font-size: 2.5rem;" class="text-warning mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem; font-weight: 500">Sakit</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                        <span class="badge bg-danger" style="position: absolute; top: 10px; right: 10px; font-size: 0.8rem; z-index:999">{{$rekappresensi->jmlterlambat}}</span>
                        <ion-icon name="time-outline" style="font-size: 2.5rem;" class="text-danger mb-1"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem; font-weight: 500">Terlambat</span>
                    </div>
                </div>
            </div>
            
        </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;" >
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    
                    {{-- <ul class="listview image-listview">
                        @foreach ($historibulanini as $d)
                        @php
                            $path = Storage::url('upload/absensi'.$d->foto_in);
                        @endphp
                        <li>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="browsers-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</div>
                                    <span class="badge badge-success">{{$d->jam_in}}</span>
                                    <span class="badge badge-danger">{{ $presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul> --}}
                    <style>
                        .historicontent {
                            display: flex;
                        }

                        .datapresensi{
                            margin-left: 10px;
                        }
                    </style>
                    @foreach ($historibulanini as $d)
                        <div class="card">
                            <div class="card-body">
                                <div class="historicontent">
                                    <div class="iconpresensi">
                                        <ion-icon name="browsers-outline" style="font-size: 48px" class="text-dark"></ion-icon>
                                    </div>
                                    <div class="datapresensi">
                                        <h3 style="line-height: 2px" >{{ $d->nama_jam_matkul }}</h3>
                                        <h4 style="margin: 0px !important">{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</h4>
                                        <span>
                                            {!! $d->jam_in != null ? date("H:i", strtotime($d->jam_in)) : '<span class="text-danger" >Belum Absen!</span>' !!}
                                            {!! $d->jam_out != null ? "-". date("H:i", strtotime($d->jam_out)) : '<span class="text-danger" >- Belum Absen!</span>' !!}
                                        </span>
                                        <div class="mt-2" id="keterangan">
                                            @php
                                                //jam ketika absen
                                                $jam_in = date("H:i", strtotime($d->jam_in));

                                                //jam jadwal masuk
                                                $jam_masuk = date("H:i", strtotime($d->jam_masuk));

                                                $jadwal_jam_masuk = $d->tgl_presensi. " " . $jam_masuk;
                                                $jam_presensi = $d->tgl_presensi. " " . $jam_in;
                                            @endphp
                                            @if ($jam_in > $jam_masuk)
                                            @php
                                                $jml_terlambat = hitungjamterlambat($jadwal_jam_masuk, $jam_presensi);
                                            @endphp
                                            <span class="danger">Terlambat {{ $jml_terlambat }}</span>
                                            @else
                                            <span style="color: green">Tepat waktu</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach($leaderboard as $d)
                        <li>
                            <div class="item">
                                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>
                                        <b>{{ $d->nama_lengkap }}</b><br>
                                        <small class="text-muted">{{ $d->kelas}}</small>
                                </div>
                                    <span class="badge {{ $d->jam_in < "07:00" ? "bg-success" : "bg-danger"}}">
                                    {{ $d->jam_in}}
                                </span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection