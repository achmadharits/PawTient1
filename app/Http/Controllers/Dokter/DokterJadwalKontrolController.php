<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
use App\Models\JadwalPraktik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DokterJadwalKontrolController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // cek status jadwal
        JadwalKontrol::where('tgl_jadwal', '<', now()->toDateString())
        ->where('status', 'Aktif')
        ->update(['status' => 'Selesai']);

        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = JadwalKontrol::where('id_dokter', $id)
        ->orderBy('status')
        ->orderByRaw("CASE WHEN status = 'Aktif' THEN 0 ELSE 1 END")
        ->orderByRaw("ABS(DATEDIFF(NOW(), tgl_jadwal))")
        ->get();
        // $datas = JadwalKontrol::where('id_dokter', $id)
        // ->orderBy('status', 'asc')
        // ->get();
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
        $id = Auth::guard('dokter')->user()->id_dokter;
        $tanggal = JadwalPraktik::where('id_dokter', $id)->get();

        foreach($tanggal as $tgl){
            if($tgl->hari == "Senin"){
                $tgl->hari = 1;
            }elseif($tgl->hari == "Selasa"){
                $tgl->hari = 2;
            }elseif($tgl->hari == "Rabu"){
                $tgl->hari = 3;
            }elseif($tgl->hari == "Kamis"){
                $tgl->hari = 4;
            }elseif($tgl->hari == "Jumat"){
                $tgl->hari = 5;
            }elseif($tgl->hari == "Sabtu"){
                $tgl->hari = 6;
            }elseif($tgl->hari == "Minggu"){
                $tgl->hari = 7;
            }
        }
        return view('dokter.jadwal.create', [
            'title' => 'jadwal',
            'datas' => $datas,
            'tanggal' => $tanggal->pluck('hari'),
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
        
        // change date format
        $newTgl = Carbon::createFromFormat('Y/m/d', $request['tgl_jadwal'])->format('Y-m-d');

        $jadwal = JadwalKontrol::create([
            'id_jadwal' => $id_jadwalCustom,
            'id_dokter' => $request['id_dokter'],
            'id_pasien' => $request['id_pasien'],
            'tgl_jadwal' => $newTgl,
            'status' => 'Undelivered',
        ]);
        
        // create reminder message
        $id = Auth::guard('dokter')->user()->id_dokter;
        $hari = $this->setDay($jadwal->tgl_jadwal);
        $jam = JadwalPraktik::where('id_dokter', $id)->where('hari', $hari)->first();
        $pesan = 'Halo '.$jadwal->pasien->nama.', kamu ada jadwal melakukan kontrol dengan drg. '.$jadwal->dokter->nama.' pada '.$this->setDate($jadwal->tgl_jadwal).'. Silakan datang ke klinik pada jam praktik '.$jam->jam_kerja.' WIB.';
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
            $jadwal->status = 'Aktif';
            $jadwal->save(); 
            return redirect('jadwal-kontrol')->withSuccess('Jadwal berhasil dibuat.');
        } else {
            return redirect('jadwal-kontrol');
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
        $id = Auth::guard('dokter')->user()->id_dokter;
        $tanggal = JadwalPraktik::where('id_dokter', $id)->get();
        foreach($tanggal as $tgl){
            if($tgl->hari == "Senin"){
                $tgl->hari = 1;
            }elseif($tgl->hari == "Selasa"){
                $tgl->hari = 2;
            }elseif($tgl->hari == "Rabu"){
                $tgl->hari = 3;
            }elseif($tgl->hari == "Kamis"){
                $tgl->hari = 4;
            }elseif($tgl->hari == "Jumat"){
                $tgl->hari = 5;
            }elseif($tgl->hari == "Sabtu"){
                $tgl->hari = 6;
            }elseif($tgl->hari == "Minggu"){
                $tgl->hari = 7;
            }
        }

        return view('dokter.jadwal.edit', [
            'title' => 'jadwal',
            'datas' => $datas,
            'tanggal' => $tanggal->pluck('hari'),
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

        // change date format
        $newTgl = Carbon::createFromFormat('Y/m/d', $request['tgl_jadwal'])->format('Y-m-d');

        $datas->tgl_jadwal = $newTgl;
        $datas->save();
        return redirect('jadwal-kontrol')->withSuccess('Data jadwal berhasil diubah.');
    }

    public function cancelJadwal($id)
    {
        $datas = JadwalKontrol::find($id);
        $datas->update(['status' => 'Batal']);

        // create reminder message
        $pesan = 'Halo '.$datas->pasien->nama.', kami memohon maaf untuk jadwal kontrol dengan drg. '.$datas->dokter->nama.' pada '.$this->setDate($datas->tgl_jadwal).' dibatalkan.\nSilakan menunggu jadwal terbaru atau mengajukan reservasi jadwal kepada dokter gigi yang bersangkutan. Terima kasih.';
        // $response = Http::withHeaders(['Authorization' => 'zn#w4#AY8zmfdpnk6PJ8'])->post('https://api.fonnte.com/device');
        $response = Http::withHeaders([
            'Authorization' => 'zn#w4#AY8zmfdpnk6PJ8', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $datas->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        return redirect('jadwal-kontrol')->withSuccess('Data jadwal berhasil dibatalkan.');
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
        return redirect('jadwal-kontrol')->withSuccess('Data jadwal berhasil dihapus.');
    }
}
