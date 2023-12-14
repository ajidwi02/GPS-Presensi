<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;



class ProdiController extends Controller
{
    public function index(Request $request){
        
        $nama_prodi = $request->nama_prodi; 
        $query = Prodi::query();
        $query->select('*');
        if(!empty($nama_prodi)){
            $query->where('nama_prodi', 'like', '%' . $nama_prodi. '%');
        }
        $prodi = $query->get();
        // $prodi = DB::table('prodi')->orderBy('kode_prodi')->get();
        return view('prodi.index', compact('prodi'));
    }

    public function store(Request $request){
        $kode_prodi = $request->kode_prodi;
        $nama_prodi = $request->nama_prodi;
        $data = [
            'kode_prodi' => $kode_prodi,
            'nama_prodi' => $nama_prodi
        ];

        $simpan = DB::table('prodi')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } else {
            return Redirect::back()->with(['warning'=> 'Data gagal disimpan']);  
        }
    }

    public function edit(Request $request){
        $kode_prodi = $request->kode_prodi;
        $prodi = DB::table('prodi')->where('kode_prodi', $kode_prodi)->first();
        return view('prodi.edit', compact('prodi'));
    }

    public function update($kode_prodi ,Request $request){
        $nama_prodi = $request->nama_prodi;
        $data = [
            'nama_prodi' => $nama_prodi
        ];

        $update = DB::table('prodi')->where('kode_prodi', $kode_prodi)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data berhasil diupadte']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupadte']);
        }
        
    }

    public function delete($kode_prodi){
        $hapus = DB::table('prodi')->where('kode_prodi', $kode_prodi)->delete();
        if($hapus){
            return Redirect::back()->with(['success' => 'Data berhasil diupadte']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupadte']);
        }
    }
}