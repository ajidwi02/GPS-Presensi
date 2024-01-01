<?php

namespace App\Http\Controllers;

use App\Models\Setjamkerja;
use App\Models\Setjammatkulkelas;
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

    public function jammatkul(){
        $jam_matkul = DB::table('jam_matkul')->orderBy('kode_jam_matkul')->get();
        return view('konfigurasi.jammatkul', compact('jam_matkul'));
    }

    public function storejammatkul(Request $request){
        $kode_jam_matkul = $request->kode_jam_matkul;
        $nama_jam_matkul = $request->nama_jam_matkul;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $dosen_pengampu = $request->dosen_pengampu;

        $data = [
            'kode_jam_matkul' => $kode_jam_matkul,
            'nama_jam_matkul' => $nama_jam_matkul,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang,
            'keterangan' => $dosen_pengampu,
        ];
        
        try{
            DB::table('jam_matkul')->insert($data);
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e){
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);
        }
    }
    

    public function updatejammatkul(Request $request){
        $kode_jam_matkul = $request->kode_jam_matkul;
        $nama_jam_matkul = $request->nama_jam_matkul;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $dosen_pengampu = $request->dosen_pengampu;

        $data = [
            'nama_jam_matkul' => $nama_jam_matkul,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang,
            'keterangan' => $dosen_pengampu,
        ];
        
        try{
            DB::table('jam_matkul')->where('kode_jam_matkul', $kode_jam_matkul)->update($data);
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } catch (\Exception $e){
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }
    

    public function editjammatkul(Request $request){
        $kode_jam_matkul = $request->kode_jam_matkul;
        $jam_matkul = DB::table('jam_matkul')->where('kode_jam_matkul', $kode_jam_matkul)->first();
        return view('konfigurasi.editjammatkul', compact('jam_matkul'));
    }

    public function deletejammatkul($kode_jam_matkul){
        $hapus = DB::table('jam_matkul')->where('kode_jam_matkul', $kode_jam_matkul)->delete();
        if($hapus){
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal dihapus']);
        }
    }

    public function setjammatkul($nim){
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
        $jammatkul = DB::table('jam_matkul')->orderBy('nama_jam_matkul')->get();
        $cekjammatkul = DB::table('konfigurasi_jam_matkul')->where('nim', $nim)->count();
        // dd($cekjammatkul);
        if($cekjammatkul>0){
            $setjammatkul = DB::table('konfigurasi_jam_matkul')->where('nim', $nim)->get();
            return view('konfigurasi.editsetjammatkul', compact('mahasiswa', 'jammatkul', 'cekjammatkul', 'setjammatkul'));
        } else {
            return view('konfigurasi.setjammatkul', compact('mahasiswa', 'jammatkul', 'cekjammatkul'));
        }
    }

    public function storesetjammatkul(Request $request){
        $nim = $request->nim;
        $hari = $request->hari;
        $kodejammatkul = $request->kode_jam_matkul;
        
        for($i=0; $i<count($hari);$i++){
            $data[] = [
                'nim' => $nim,
                'hari' => $hari[$i],
                'kode_jam_matkul' => $kodejammatkul[$i]
            ];
        }

        try {
            Setjamkerja::insert($data);
            return redirect('/mahasiswa')->with(['success' => 'Konfigurasi jam matkul berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect('/mahasiswa')->with(['warning' => 'Konfigurasi jam matkul gagal ditambahkan']);
        }
    }
    
    public function updatesetjammatkul(Request $request){
        $nim = $request->nim;
        $hari = $request->hari;
        $kodejammatkul = $request->kode_jam_matkul;
        
        for($i=0; $i<count($hari);$i++){
            $data[] = [
                'nim' => $nim,
                'hari' => $hari[$i],
                'kode_jam_matkul' => $kodejammatkul[$i]
            ];
        }

        DB::beginTransaction();
        try {
            DB::table('konfigurasi_jam_matkul')->where('nim', $nim)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/mahasiswa')->with(['success' => 'Konfigurasi jam matkul berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/mahasiswa')->with(['warning' => 'Konfigurasi jam matkul gagal ditambahkan']);
        }
    }

    public function jammatkulkelas(){
        $jammatkulkelas =DB::table('konfigurasi_jm_kelas')
            ->join('prodi', 'konfigurasi_jm_kelas.kode_kelas', '=', 'prodi.kode_prodi')
            ->get();
        
        return view('konfigurasi.jammatkulkelas', compact('jammatkulkelas'));
    }

    public function createjammatkulkelas(){
        $jammatkul = DB::table('jam_matkul')->orderBy('nama_jam_matkul')->get();
        $kelas = DB::table('prodi')->get();
        return view('konfigurasi.createjammatkulkelas', compact('jammatkul', 'kelas'));
    }

    public function storejammatkulkelas(Request $request){
        $kode_kelas = $request->kode_kelas;
        $hari = $request->hari;
        $kodejammatkul = $request->kode_jam_matkul;
        $kode_jm_kelas = 'J' . $kode_kelas;
        
        DB::beginTransaction();
        try {
            //Menyimpan data ke tabel konfigurasi_jm_kelas
            DB::table('konfigurasi_jm_kelas')->insert([
                'kode_jm_kelas' => $kode_jm_kelas,
                'kode_kelas' => $kode_kelas
            ]);

            for($i=0; $i<count($hari);$i++){
                $data[] = [
                    'kode_jm_kelas' => $kode_jm_kelas,
                    'hari' => $hari[$i],
                    'kode_jam_matkul' => $kodejammatkul[$i]
                ];
            }
            //diinput dalam tabel konfigurasi_jm_kelas_detail
            Setjammatkulkelas::insert($data);
            DB::commit();
            return redirect('/konfigurasi/jammatkulkelas')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Exception $e) {
            //Jika eror akan ditarik ulang (Rollback)
            DB::rollback();
            return redirect('/konfigurasi/jammatkulkelas')->with(['warning' => 'Data Gagal Disimpan!']);
        }
    }

    public function editjammatkulkelas($kode_jm_kelas){
        $jammatkul = DB::table('jam_matkul')->orderBy('nama_jam_matkul')->get();
        $kelas = DB::table('prodi')->get();
        $jam_matkul_kelas = DB::table('konfigurasi_jm_kelas')
            ->where('kode_jm_kelas', $kode_jm_kelas)
            ->first();
        $jam_matkul_kelas_detail = DB::table('konfigurasi_jm_kelas_detail')
            ->where('kode_jm_kelas', $kode_jm_kelas)
            ->get();
        return view('konfigurasi.editjammatkulkelas', compact('jammatkul', 'kelas','jam_matkul_kelas','jam_matkul_kelas_detail'));
    }

    public function updatejammatkulkelas($kode_jm_kelas, Request $request){
        $hari = $request->hari;
        $kodejammatkul = $request->kode_jam_matkul;
        
        DB::beginTransaction();
        try {
            //Hapus Data sebelumnya
            DB::table('konfigurasi_jm_kelas_detail')->where('kode_jm_kelas', $kode_jm_kelas)->delete();
            
            for($i=0; $i<count($hari);$i++){
                $data[] = [
                    'kode_jm_kelas' => $kode_jm_kelas,
                    'hari' => $hari[$i],
                    'kode_jam_matkul' => $kodejammatkul[$i]
                ];
            }
            //diinput dalam tabel konfigurasi_jm_kelas_detail
            Setjammatkulkelas::insert($data);
            DB::commit();
            return redirect('/konfigurasi/jammatkulkelas')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Exception $e) {
            //Jika eror akan ditarik ulang (Rollback)
            DB::rollback();
            return redirect('/konfigurasi/jammatkulkelas')->with(['warning' => 'Data Gagal Disimpan!']);
        }
    }
    

    public function showjammatkulkelas($kode_jm_kelas){
        $jammatkul = DB::table('jam_matkul')->orderBy('nama_jam_matkul')->get();
        $kelas = DB::table('prodi')->get();
        $jam_matkul_kelas = DB::table('konfigurasi_jm_kelas')
            ->where('kode_jm_kelas', $kode_jm_kelas)
            ->first();
        $jam_matkul_kelas_detail = DB::table('konfigurasi_jm_kelas_detail')
            ->join('jam_matkul', 'konfigurasi_jm_kelas_detail.kode_jam_matkul', '=', 'jam_matkul.kode_jam_matkul')
            ->where('kode_jm_kelas', $kode_jm_kelas)
            ->get();
        return view('konfigurasi.showjammatkulkelas', compact('jammatkul', 'kelas','jam_matkul_kelas','jam_matkul_kelas_detail'));
    }

    public function deletejammatkulkelas($kode_jm_kelas){
        try {
            //Querry menghapus data
            DB::table('konfigurasi_jm_kelas')->where('kode_jm_kelas', $kode_jm_kelas)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            //throw $th;
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}