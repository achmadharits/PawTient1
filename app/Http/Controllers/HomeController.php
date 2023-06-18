<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
use App\Models\JadwalPraktik;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setDate($date)
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('l, d F Y');
    }
    public function index()
    {
        if(Auth::guard('dokter')->check()){
            $id = Auth::guard('dokter')->user()->id_dokter;
            $datas = JadwalKontrol::where('id_dokter', $id)
            ->where('tgl_jadwal', now()->toDateString())
            ->where('status', 'Aktif')
            ->orderBy('antrian')
            ->get();
            $jadwal = JadwalKontrol::where('id_dokter', $id)->where('status', 'Aktif')->count();
            $reservasi = Reservasi::where('id_dokter', $id)->where('status', 'Menunggu')->count();
            $praktik = JadwalPraktik::where('id_dokter', $id)->get();
            return view('dokter.dashboard.index', [
                'datas' => $datas,
                'praktik' => $praktik,
                'title' => 'home',
                'jadwal' => $jadwal,
                'reservasi' => $reservasi,
            ]);
        }elseif(Auth::guard('pasien')->check()){
            $id = Auth::guard('pasien')->user()->id_pasien;
            $datas = JadwalKontrol::where('id_pasien', $id)
            ->where('status', 'Aktif')
            ->orderBy('tgl_jadwal', 'asc')
            ->get();
            $riwayat = JadwalKontrol::where('id_pasien', $id)
            ->where('status', 'Selesai')
            ->get();
            
            $jadwal = JadwalKontrol::where('id_pasien', $id)->where('status', 'Aktif')->count();
            $reservasi = Reservasi::where('id_pasien', $id)->where('status', 'Menunggu')->count();
            return view('pasien.dashboard.index', [
                'title' => 'home',
                'datas' => $datas,
                'riwayat' => $riwayat,
                'reservasi' => $reservasi,
                'jadwal' => $jadwal,
            ]);
        }
        
    }
}
