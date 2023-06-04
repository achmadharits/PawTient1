<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
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
    public function index()
    {
        if(Auth::guard('dokter')->check()){
            $id = Auth::guard('dokter')->user()->id_dokter;
            $datas = Dokter::all();
            $pasien = Pasien::limit(5)->get();
            $jadwal = JadwalKontrol::where('status', 'Aktif')->count();
            $reservasi = Reservasi::where('id_dokter', $id)->where('status', 'Menunggu')->count();
            return view('dokter.dashboard.index', [
                'datas' => $datas,
                'title' => 'home',
                'jadwal' => $jadwal,
                'reservasi' => $reservasi,
                'pasien' => $pasien,
            ]);
        }elseif(Auth::guard('pasien')->check()){
            return view('pasien.dashboard.index', [
                'title' => 'home',
            ]);
        }
        
    }
}
