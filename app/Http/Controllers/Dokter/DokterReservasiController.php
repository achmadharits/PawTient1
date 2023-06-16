<?php

namespace App\Http\Controllers\Dokter;

use Carbon\Carbon;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
use App\Models\JadwalPraktik;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DokterReservasiController extends Controller
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
    public function setDay($date)
    {
        Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('l');
    }
    public function setTime($time)
    {
        Carbon::setLocale('id');
        return Carbon::parse($time)->translatedFormat('h:i');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = Reservasi::where('id_dokter', $id)
        ->where('status', 'Menunggu')
        ->get();
        return view('dokter.reservasi.index', [
            'title' => 'reservasi',
            'datas' => $datas,
        ]);
    }
    
    public function saveJadwal($id)
    {
        $id_jadwalCustom = JadwalKontrol::pluck('id_jadwal')->count();
        
        $id_jadwalCustom = $this->getIdJadwal($id_jadwalCustom + 1);
        while(JadwalKontrol::where('id_jadwal', $id_jadwalCustom)->exists()){
            $id_jadwalCustom++;
        }

        $datas = Reservasi::find($id);
        $jadwal = JadwalKontrol::create([
            'id_jadwal' => $id_jadwalCustom,
            'id_dokter' => $datas->id_dokter,
            'id_pasien' => $datas->id_pasien,
            'tgl_jadwal' => $datas->tgl_reservasi,
            'jam_jadwal' => $datas->jam_reservasi,
            'status' => 'Undelivered',
        ]);
        $datas->update(['status' => 'Disetujui']);

        // get day
        $hari = $this->setDay($jadwal->tgl_jadwal);
        $jam = JadwalPraktik::where('id_dokter', $datas->id_dokter)->where('hari', $hari)->first();

        // create reminder message
        $pesan = 'Halo '.$jadwal->pasien->nama.'. Pengajuan reservasi untuk melakukan kontrol dengan drg. '
        .$jadwal->dokter->nama.' pada '.$this->setDate($jadwal->tgl_jadwal).' telah disetujui. Silakan datang pada pukul '
        .$this->setTime($jadwal->jam_jadwal).' WIB sesuai yang diajukan. Terima kasih.'.PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.'*Klinik Gigi Bara Senyum*'.
        PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';
        
        // $response = Http::withHeaders(['Authorization' => 'zn#w4#AY8zmfdpnk6PJ8'])->post('https://api.fonnte.com/device');
        $response = Http::withHeaders([
            'Authorization' => '3obysh37CBiBiY7F@ood', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $jadwal->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        
        if ($response->ok()) {
            // $responseData = $response->json();
            $jadwal->pesan = $pesan;
            $jadwal->status = 'Aktif';
            $jadwal->save(); 
            return redirect('/dokter/reservasi')->withSuccess('Reservasi berhasil disetujui.');
        } else {
            return redirect('/dokter/reservasi');
            $errorMessage = $response->body();
        }
    }
    public function declineJadwal($id)
    {
        $datas = Reservasi::find($id);

        // create announcement message
        $pesan = 'Halo '.$datas->pasien->nama.'. Kami memohon maaf untuk pengajuan reservasi untuk melakukan kontrol dengan drg. '
        .$datas->dokter->nama.' pada '.$this->setDate($datas->tgl_reservasi).' pukul '.$this->setTime($datas->jam_jadwal).' WIB kami tolak.'.PHP_EOL.
        'Silakan mengajukan reservasi kembali di tanggal yang berbeda. Terima kasih.'.PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.
        '*Klinik Gigi Bara Senyum*'.PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';

        $response = Http::withHeaders([
            'Authorization' => '3obysh37CBiBiY7F@ood', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $datas->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        
        if ($response->ok()) {
            // $responseData = $response->json();
            $datas->update(['status' => 'Ditolak']);
            return redirect('/dokter/reservasi')->withSuccess('Reservasi berhasil ditolak.');
        } else {
            return redirect('/dokter/reservasi');
            $errorMessage = $response->body();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
