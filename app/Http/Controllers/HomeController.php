<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\JadwalKontrol;
use App\Models\Pasien;
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
            $datas = Dokter::all();
            $jadwal = JadwalKontrol::where('status', 'Aktif')->count();
            return view('dokter.dashboard.index', [
                'datas' => $datas,
                'title' => 'home',
                'jadwal' => $jadwal,
            ]);
        }elseif(Auth::guard('pasien')->check()){
            return view('pasien.dashboard.index', [
                'title' => 'home',
            ]);
        }
        
    }
}
