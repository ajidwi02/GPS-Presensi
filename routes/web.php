<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\konfigurasiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['guest:mahasiswa'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);

});

Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('user.index');
    Route::post('/presensi/store', [PresensiController::class, 'store']);
    
    //Edit Profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nim}/updateprofile', [PresensiController::class, 'updateprofile']);
    
    //Histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);
    
    //Izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
    Route::post('/mahasiswa/store', [MahasiswaController::class, 'store']);
    Route::post('/mahasiswa/edit', [MahasiswaController::class, 'edit']);
    Route::post('/mahasiswa/{nim}/update', [MahasiswaController::class, 'update']);
    Route::post('/mahasiswa/{nim}/delete', [MahasiswaController::class, 'delete']);


    //Matkul 
    Route::get('/prodi', [ProdiController::class, 'index']);
    Route::post('/prodi/store', [ProdiController::class, 'store']);
    Route::post('/prodi/edit', [ProdiController::class, 'edit']);
    Route::post('/prodi/{kode_prodi}/update', [ProdiController::class, 'update']);
    Route::post('/prodi/{kode_prodi}/delete', [ProdiController::class, 'delete']);
    
    
    //Monitoring
    Route::get('/epresensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
    Route::get('/epresensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);
    
    // Konfigurasi
    Route::get('/konfigurasi/lokasiKampus', [konfigurasiController::class, 'lokasiKampus']);
    Route::post('/konfigurasi/updatelokasiKampus', [konfigurasiController::class, 'updatelokasiKampus']);
    Route::get('/konfigurasi/jammatkul', [konfigurasiController::class, 'jammatkul']);
    Route::post('/konfigurasi/storejammatkul', [konfigurasiController::class, 'storejammatkul']);
    Route::post('/konfigurasi/editjammatkul', [konfigurasiController::class, 'editjammatkul']);
    Route::post('/konfigurasi/updatejammatkul', [konfigurasiController::class, 'updatejammatkul']);
    Route::post('/konfigurasi/{kode_jam_matkul}/delete', [konfigurasiController::class, 'deletejammatkul']);
    Route::get('/konfigurasi/{nim}/setjammatkul', [konfigurasiController::class, 'setjammatkul']);
    Route::post('/konfigurasi/storesetjammatkul', [konfigurasiController::class, 'storesetjammatkul']);
    Route::post('/konfigurasi/updatesetjammatkul', [konfigurasiController::class, 'updatesetjammatkul']);   

    
    Route::get('/konfigurasi/jammatkulkelas', [konfigurasiController::class, 'jammatkulkelas']);   
    Route::get('/konfigurasi/jammatkulkelas/create', [konfigurasiController::class, 'createjammatkulkelas']);   
    Route::post('/konfigurasi/jammatkulkelas/store', [konfigurasiController::class, 'storejammatkulkelas']);  
    Route::get('/konfigurasi/jammatkulkelas/{kode_jm_kelas}/edit', [konfigurasiController::class, 'editjammatkulkelas']);   
    Route::get('/konfigurasi/jammatkulkelas/{kode_jm_kelas}/show', [konfigurasiController::class, 'showjammatkulkelas']);   
    Route::post('/konfigurasi/jammatkulkelas/{kode_jm_kelas}/update', [konfigurasiController::class, 'updatejammatkulkelas']);  
    Route::get('/konfigurasi/jammatkulkelas/{kode_jm_kelas}/delete', [konfigurasiController::class, 'deletejammatkulkelas']);   
    
});