<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class konfigurasiController extends Controller
{
    public function lokasiKampus(){
        $lokasiKampus = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasiKampus', compact('lokasiKampus'));
    }

    public function updatelokasiKampus(Request $request){
        $lokasiKampus = $request->lokasiKampus;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasi')->where('id', 1)->update([
            'lokasi_kampus' => $lokasiKampus,
            'radius' => $radius
        ]);

        if($update){
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning'=>'Data gagal diupdate']);
        }
    }
}