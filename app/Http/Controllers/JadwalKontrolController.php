<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class JadwalKontrolController extends Controller
{
    public function getIdJadwal($id)
    {
        if($id > 9){
            return 'J' . $id;
        }else{
            return 'J0' . $id;
        }
    }

    public function setDate($date)
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('l, d F Y');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $datas = JadwalKontrol::all();
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = JadwalKontrol::where('id_dokter', $id)->orderBy('tgl_jadwal', 'desc')->get();
        return view('dokter.jadwal.index', [
            'title' => 'jadwal',
            'datas' => $datas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = Pasien::all();
        return view('dokter.jadwal.create', [
            'title' => 'jadwal',
            'datas' => $datas,
        ]);
        
    }

    public function store(Request $request)
    {
        // create scheduled reminder
        // $tanggal = $request['tgl_jadwal'];
        // $time = $tanggal . ' 01:00';
        // dd(strtotime($time)); 

        $request->validate([
            'id_pasien' => 'required|not_in:null',
            'tgl_jadwal' => 'required|date|after:today',
        ]);

        $id_jadwalCustom = JadwalKontrol::pluck('id_jadwal')->count();
        
        $id_jadwalCustom = $this->getIdJadwal($id_jadwalCustom + 1);
        while(JadwalKontrol::where('id_jadwal', $id_jadwalCustom)->exists()){
            $id_jadwalCustom++;
        }
        
        $jadwal = JadwalKontrol::create([
            'id_jadwal' => $id_jadwalCustom,
            'id_dokter' => $request['id_dokter'],
            'id_pasien' => $request['id_pasien'],
            'tgl_jadwal' => $request['tgl_jadwal'],
            'status' => 'Undelivered',
        ]);
        
        // create reminder message
        $pesan = 'Halo ' . $jadwal->pasien->nama . ', kamu ada jadwal melakukan kontrol dengan drg. ' . $jadwal->dokter->nama . ' pada '. $this->setDate($jadwal->tgl_jadwal);
        // $response = Http::withHeaders(['Authorization' => 'zn#w4#AY8zmfdpnk6PJ8'])->post('https://api.fonnte.com/device');
        $response = Http::withHeaders([
            'Authorization' => 'zn#w4#AY8zmfdpnk6PJ8', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $jadwal->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        
        if ($response->ok()) {
            // $responseData = $response->json();
            $jadwal->pesan = $pesan;
            $jadwal->status = 'Active';
            $jadwal->save(); 
            return redirect('jadwal')->withSuccess('Jadwal berhasil dibuat.');
        } else {
            return redirect('jadwal');
            $errorMessage = $response->body();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas = JadwalKontrol::find($id);
        return view('dokter.jadwal.edit', [
            'title' => 'jadwal',
            'datas' => $datas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_jadwal' => 'required|date|after:today',
        ]);
        $datas = JadwalKontrol::find($id);

        $datas->tgl_jadwal = $request->tgl_jadwal;
        $datas->save();
        return redirect('jadwal')->withSuccess('Data jadwal berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datas = JadwalKontrol::find($id);
        $datas->delete();
        return redirect('jadwal')->withSuccess('Data jadwal berhasil dihapus.');

    }
}
