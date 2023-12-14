<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;



class MahasiswaController extends Controller
{
    public function index(Request $request){

        
        $query = Mahasiswa::query();
        $query->select('mahasiswa.*' ,'nama_prodi');
        $query->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi');
        $query->orderBy('nama_lengkap');
        if(!empty($request->nama_mahasiswa)){
            $query->where('nama_lengkap', 'like', '%' . $request->nama_mahasiswa . '%');
        }

        if(!empty($request->kode_prodi)){
            $query->where('mahasiswa.kode_prodi',$request->kode_prodi);
        }
        
        $mahasiswa = $query->paginate(10);

        // $mahasiswa = DB::table('mahasiswa')->orderBy('nama_lengkap')
        // ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
        // ->paginate(2);
        
        $prodi = DB::table('prodi')->get();
        return view('mahasiswa.index', compact('mahasiswa', 'prodi'));
        
    }

    public function store(Request $request){
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $kelas = $request->kelas;
        $no_hp = $request->no_hp;
        $kode_prodi = $request->kode_prodi;
        $password = Hash::make('12345');

        if ($request->hasFile('foto')){
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nim' => $nim,
                'nama_lengkap' => $nama_lengkap,
                'kelas' => $kelas,
                'no_hp' => $no_hp,
                'kode_prodi' => $kode_prodi,
                'foto' => $foto,
                'password' => $password,
            ];
            $simpan = DB::table('mahasiswa')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/upload/mahasiswa/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
            } 
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);
        }
    }

    public function edit(Request $request){
        $nim = $request->nim;
        $prodi = DB::table('prodi')->get();
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        // return dd($mahasiswa);
        return view('mahasiswa.edit', compact('prodi', 'mahasiswa'));
    }

    public function update($nim ,Request $request){
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $kelas = $request->kelas;
        $no_hp = $request->no_hp;
        $kode_prodi = $request->kode_prodi;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')){
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'kelas' => $kelas,
                'no_hp' => $no_hp,
                'kode_prodi' => $kode_prodi,
                'foto' => $foto,
                'password' => $password,
            ];
            $update = DB::table('mahasiswa')->where('nim', $nim)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/upload/mahasiswa/";
                    $folderPathOld = "public/upload/mahasiswa/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
            } 
        } catch (\Exception $e) {
            // dd($e);
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }
    public function delete($nim){
        $delete = DB::table('mahasiswa')->where('nim', $nim)->delete();
        if($delete){
            return Redirect::back()->with(['success'=> 'Data berhasil dihapus']);
        } else{
            return Redirect::back()->with(['error'=> 'Data gagal dihapus']);
        } 
    }
}