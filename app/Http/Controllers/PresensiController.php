<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


class PresensiController extends Controller
{
    public function gethari(){
        $hari = date("D");
        
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "Kamis";
                break;
            case 'Fri':
                $hari_ini = "Jum'at";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;
            default :
                $hari_ini = "Tidak di ketahui";
                break;    
        } 
        return $hari_ini;
    }
    
    public function create()
    {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nim', $nim)->count();
        $lokasiKampus = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $jam_matkul = DB::table('konfigurasi_jam_matkul')
            ->join('jam_matkul', 'konfigurasi_jam_matkul.kode_jam_matkul','=','jam_matkul.kode_jam_matkul')
            ->where('nim', $nim)
            ->where('hari', $namahari)
            ->first();
        
        return view('presensi.create', compact('cek', 'lokasiKampus', 'jam_matkul'));
    }

    public function store(Request $request)
    {
        
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lokasiKampus = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(",", $lokasiKampus->lokasi_kampus);
        $lat = $lok[0];
        $long = $lok[1];
        $latitudekampus = $lat;
        $longitudekampus = $long;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekampus, $longitudekampus, $latitudekampus, $longitudeuser);
        $radius = round($jarak["meters"]);
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->count();

        if($cek > 0){
            $ket = "out";
        } else {
            $ket = "in";
        }
        
        $image = $request->image;
        $folderPath = "public/upload/absensi";
        $formatName = $nim . "-" . $tgl_presensi . "-" . $ket ;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $data = [
            'nim' => $nim,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi
        ];
        
        
        if($radius > $lokasiKampus->radius){
            echo "error|Maaf anda berada diluar radius!, jarak anda ".$radius." meter dari kampus|radius";
        } else {
            if($cek > 0){
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->update($data_pulang);

                if($update){
                    echo"success|Sampai Jumpa, Hati Hati di jalan|out"; 
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Absen Gagal, Silahkan Hubungi Dosen|out";
                }
            } else {
                $data = [
                    'nim' => $nim,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
                ];
                
                $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo"success|Terimakasih, Selamat Belajar|in";  
                    Storage::put($file, $image_base64);
                } else {
                    echo "1";
                    echo "error|Absen Gagal, Silahkan Hubungi Dosen|in";
                }
            }
        }
    }

    //Menghitung validasi jarak koordinat
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
    
    public function editprofile(){
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $mahasiswa = DB::table('mahasiswa')
        ->where('nim', $nim)
        ->first();
        return view('presensi.editprofile', compact('mahasiswa'));
    }

    public function updateprofile(Request $request){
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $mahasiswa= DB::table('mahasiswa')->where('nim', $nim)->first(); 
        
        if ($request->hasFile('foto')){
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $mahasiswa->foto;
        }
        
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto                
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto                
            ];    
        }

        $update = DB::table('mahasiswa')->where('nim', $nim)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/upload/mahasiswa/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with(['success'=>'Data berhasil di update']);
        } else {
            return redirect()->back()->with(['error'=>'Data gagal di update']);
        }
    }

    public function histori()
    {
        $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        return view('presensi.histori', compact('nama_bulan'));
    }

    public function gethistori(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $nim = Auth::guard('mahasiswa')->user()->nim;

        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('nim', $nim)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin(){
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $dataizin = DB::table('pengajuan_izin')->where('nim', $nim)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin(){
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request){
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nim' => $nim,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        

        if($simpan){
            return redirect('/presensi/izin')->with(['success'=>'Data berhasil disimpan']);
        } else {
            return redirect('/presensi/izin')->with(['error'=>'Data gagal disimpan']);
        }
    }

    public function monitoring(){
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request){
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_lengkap', 'nama_prodi')
        ->join('mahasiswa', 'presensi.nim', '=', 'mahasiswa.nim')
        ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function tampilkanpeta(Request $request){
        $id = $request->id;
        $presensi = DB::table('presensi')
            ->where('id', $id)
            ->join('mahasiswa', 'presensi.nim', '=', 'mahasiswa.nim')
            ->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporan(){
        $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $mahasiswa = DB::table('mahasiswa')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('nama_bulan', 'mahasiswa'));
    }

    public function cetaklaporan(Request $request){
        $nama_bulan = ["", "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];

        $nim = $request->nim;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)
        ->join('prodi', 'mahasiswa.kode_prodi', '=', 'prodi.kode_prodi')
        ->first();
        $presensi = DB::table('presensi')
        ->where('nim', $nim)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->orderBy('tgl_presensi')
        ->get();

        if(isset($_POST['exportexcel'])){
            $time = date("d-M-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Presensi Mahasiswa $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'nama_bulan', 'mahasiswa', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'nama_bulan', 'mahasiswa', 'presensi'));
    }

    public function rekap(){
        $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.rekap', compact('nama_bulan'));
    }

    public function cetakrekap(Request $request){
        $nama_bulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensi')
        ->selectRaw('presensi.nim, nama_lengkap, 
            MAX(IF(DAY(tgl_presensi) = 1, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_1,
            MAX(IF(DAY(tgl_presensi) = 2, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_2,
            MAX(IF(DAY(tgl_presensi) = 3, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_3,
            MAX(IF(DAY(tgl_presensi) = 4, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_4,
            MAX(IF(DAY(tgl_presensi) = 5, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_5,
            MAX(IF(DAY(tgl_presensi) = 6, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_6,
            MAX(IF(DAY(tgl_presensi) = 7, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_7,
            MAX(IF(DAY(tgl_presensi) = 8, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_8,
            MAX(IF(DAY(tgl_presensi) = 9, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_9,
            MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_10,
            MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_11,
            MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_12,
            MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_13,
            MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_14,
            MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_15,
            MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_16,
            MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_17,
            MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_18,
            MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_19,
            MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_20,
            MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_21,
            MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_22,
            MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_23,
            MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_24,
            MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_25,
            MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_26,
            MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_27,
            MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_28,
            MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_29,
            MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_30,
            MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_31')
        ->join('mahasiswa','presensi.nim', '=', 'mahasiswa.nim')
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->groupByRaw('presensi.nim, nama_lengkap')
        ->get();

        if(isset($_POST['exportexcel'])){
            $time = date("d-M-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi Mahasiswa $time.xls");
        }
        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap', 'nama_bulan'));
    }

    public function izinsakit(Request $request){
        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nim', 'nama_lengkap', 'kelas', 'status', 'status_approved', 'keterangan');
        $query->join('mahasiswa', 'pengajuan_izin.nim', '=', 'mahasiswa.nim');
        
        if( !empty($request->dari) && !empty($request->sampai) ){
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        
        if( !empty($request->nim)){
            $query->where('pengajuan_izin.nim', $request->nim);
        }
        
        if( !empty($request->nama_mahasiswa)){
            $query->where('nama_lengkap', 'like', '%'.  $request->nama_mahasiswa. '%');
        }

        if( $request->status_approved === '0' || $request->status_approved ==='1' || $request->status_approved ==='2'){
            $query->where('status_approved', $request->status_approved);
        }
        
        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->paginate(10);
        $izinsakit->append($request->all());
        
        // $izinsakit = DB::table('pengajuan_izin')
        //     ->join('mahasiswa', 'pengajuan_izin.nim', '=', 'mahasiswa.nim')
        //     ->orderBy('tgl_izin', 'desc')
        //     ->get();
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request){
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('pengajuan_izin')
        ->where('id', $id_izinsakit_form)
        ->update([
            'status_approved' => $status_approved 
        ]);
        if($update){
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function batalkanizinsakit($id){
        $update = DB::table('pengajuan_izin')
        ->where('id', $id)
        ->update([
            'status_approved' => 0
        ]);
        if($update){
            return Redirect::back()->with(['success' => 'Data berhasil diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
        }
    }

    public function cekpengajuanizin(Request $request){
        $tgl_izin = $request->tgl_izin;
        $nim = Auth::guard('mahasiswa')->user()->nim;
        
        $cek = DB::table('pengajuan_izin')->where('nim', $nim)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}