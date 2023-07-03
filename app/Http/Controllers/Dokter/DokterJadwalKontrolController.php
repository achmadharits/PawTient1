<?php

namespace App\Http\Controllers\Dokter;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\IzinAbsensi;
use Illuminate\Http\Request;
use App\Models\JadwalKontrol;
use App\Models\JadwalPraktik;
use App\Http\Controllers\Controller;
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

    public function setTime($time)
    {
        Carbon::setLocale('id');
        return Carbon::parse($time)->translatedFormat('H:i');
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

        $tanggal = request()->query('date'); 
        $datas = JadwalKontrol::when($tanggal, function ($query) use ($tanggal) { $query->where('tgl_jadwal', $tanggal);})
        ->where('id_dokter', $id)
        ->orderBy('status')
        ->orderByRaw("CASE WHEN status = 'Aktif' THEN 0 ELSE 1 END")
        ->orderByRaw("ABS(DATEDIFF(NOW(), tgl_jadwal))")
        ->orderBy('jam_jadwal', 'asc')
        ->get();

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
        $tgl_izin = IzinAbsensi::where('id_dokter', $id)
        ->where('tgl_izin', '>', now()->toDateString())
        ->pluck('tgl_izin');

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
            'tgl_izin' => $tgl_izin,
            'id_dokter' => $id, 
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
            'jam_jadwal' => 'required'
        ]);

        $id_jadwalCustom = JadwalKontrol::pluck('id_jadwal')->count();
        
        $id_jadwalCustom = $this->getIdJadwal($id_jadwalCustom + 1);
        while(JadwalKontrol::where('id_jadwal', $id_jadwalCustom)->exists()){
            $id_jadwalCustom++;
        }
        
        // change datetime format
        $newTgl = Carbon::createFromFormat('Y/m/d', $request['tgl_jadwal'])->format('Y-m-d');
        // $newJam = Carbon::createFromFormat('H:i', $request['jam_jadwal'])->format('H:i');

        $jam =  $request['jam_jadwal'];
    
        // Cek jadwal kontrol yang sudah ada pada tanggal yang sama
        $existingJadwal = JadwalKontrol::where('tgl_jadwal', $newTgl)
            ->orderBy('jam_jadwal', 'asc')
            ->get();

        // Periksa jika jam baru sudah ada pada tanggal yang sama
        if ($existingJadwal->contains('jam_jadwal', Carbon::parse($jam)->format('H:i:s'))) {
            return redirect('jadwal-kontrol')->withError('Jadwal kontrol sudah dimiliki oleh pasien lain.');
        }
    
        $antrian = 1;
        if ($existingJadwal->count() > 0) {
            // Cari posisi jadwal baru dalam urutan jam
            $position = $existingJadwal->search(function ($item, $key) use ($jam) {
                return $item->jam_jadwal >= $jam;
            });
    
            $antrian = $position === false ? $existingJadwal->count() + 1 : $position + 1;

            // Update antrian untuk jadwal kontrol yang berada di posisi setelahnya
            if ($position !== false) {
                $existingJadwal->slice($position)->each(function ($jadwal) {
                    $jadwal->increment('antrian');
                });
            }
        } else {
            $antrian = 1;
        }

        $jadwal = JadwalKontrol::create([
            'id_jadwal' => $id_jadwalCustom,
            'id_dokter' => $request['id_dokter'],
            'id_pasien' => $request['id_pasien'],
            'tgl_jadwal' => $newTgl,
            'jam_jadwal' => $request['jam_jadwal'],
            'status' => 'Undelivered',
            'antrian' => $antrian,
        ]);
        
        // create reminder message
        $id = Auth::guard('dokter')->user()->id_dokter;
        $hari = $this->setDay($jadwal->tgl_jadwal);
        $jam = JadwalPraktik::where('id_dokter', $id)->where('hari', $hari)->first();

        $pesan = 'Halo '.$jadwal->pasien->nama.'. Kamu memiliki jadwal untuk melakukan kontrol dengan drg. '
        .$jadwal->dokter->nama.' pada '.$this->setDate($jadwal->tgl_jadwal).' pukul '.$this->setTime($jadwal->jam_jadwal).
        ' WIB dengan antrian nomor '.$jadwal->antrian.'.'.PHP_EOL.'Lakukan pengecekan antrian secara berkala pada website karena sewaktu-waktu nomor antrian bisa berubah. Terima kasih.'.
        PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.'*Klinik Gigi Bara Senyum*'.
        PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';

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
        $tgl_izin = IzinAbsensi::where('id_dokter', $id)
        ->where('tgl_izin', '>', now()->toDateString())
        ->pluck('tgl_izin');

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
            'tgl_izin' => $tgl_izin,
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
            'jam_jadwal' => 'required',
        ]);
        $datas = JadwalKontrol::find($id);
        $oldTgl = $datas->tgl_jadwal; // 20 Juni 2023
        $oldJam = $this->setTime($datas->jam_jadwal); // 13:00 antrian 1
        $antrian = 0;
        // change date format
        $newTgl = Carbon::createFromFormat('Y/m/d', $request['tgl_jadwal'])->format('Y-m-d'); // 20 juni 2023
        $jamBaru = $request['jam_jadwal']; // 17:00

        // Cek jadwal kontrol yang sudah ada pada tanggal yang sama
        $existingJadwal = JadwalKontrol::where('tgl_jadwal', $newTgl)
            ->orderBy('jam_jadwal', 'asc')
            ->get();

        // Periksa jika jam baru sama dengan jam lama
        if ($jamBaru === $oldJam && $newTgl === $oldTgl) { // ini ran masalahnya, kasih && cek tanggal juga
            return redirect('jadwal-kontrol')->withSuccess('Jam kontrol tidak berubah.');
        }

        // Periksa jika jam baru sudah ada pada tanggal yang sama
        if ($existingJadwal->contains('jam_jadwal', Carbon::parse($jamBaru)->format('H:i:s'))) {
            return redirect('jadwal-kontrol')->withError('Jadwal kontrol sudah dimiliki oleh pasien lain.');
        }

        // update data
        $datas->tgl_jadwal = $newTgl;
        $datas->jam_jadwal = $request['jam_jadwal'];
        $datas->save();

        $existingJadwal = JadwalKontrol::where('tgl_jadwal', $oldTgl)
        ->orderBy('jam_jadwal', 'asc')
        ->get();

        // ini untuk melakukan update jika tanggalnya sama


        // Sort ulang jadwal kontrol berdasarkan jam kontrol
        $existingJadwal->sortBy('jam_jadwal')->values()->each(function ($jadwal, $index) use ($jamBaru, $antrian) {
            if($jadwal->jam_jadwal == Carbon::parse($jamBaru)->format('H:i:s')){
                $antrian = $index + 1;
            }
            $jadwal->antrian = $index + 1;
            $jadwal->save();
        });


        //  ini untuk melakukan update jika tanggalnya berbeda
        // misal sebelum di update tgl 20 juni 2023 terus pas ran edit jadi tanggal 19 juni 2023
        if($newTgl != $oldTgl){
            $existingJadwal = JadwalKontrol::where('tgl_jadwal', $newTgl)
            ->orderBy('jam_jadwal', 'asc')
            ->get();
    
    
            // Sort ulang jadwal kontrol berdasarkan jam kontrol
            $existingJadwal->sortBy('jam_jadwal')->values()->each(function ($jadwal, $index) use($jamBaru, $antrian){
                if($jadwal->jam_jadwal == Carbon::parse($jamBaru)->format('H:i:s')){
                    $antrian = $index + 1;
                }
                $jadwal->antrian = $index + 1;
                $jadwal->save();
            });
            
        }

        // create reminder message
        $id = Auth::guard('dokter')->user()->id_dokter;
        $hari = $this->setDay($datas->tgl_jadwal);
        $jam = JadwalPraktik::where('id_dokter', $id)->where('hari', $hari)->first();
        $antrian = JadwalKontrol::where('tgl_jadwal', $newTgl)->where('jam_jadwal',$jamBaru)->first()->antrian;
        // dd($antrian);

        if($oldTgl == $newTgl){
            $pesan = '*[PEMBERITAHUAN]*'.PHP_EOL.PHP_EOL.'Halo '.$datas->pasien->nama.'. Untuk jadwal kontrol dengan drg. '
            .$datas->dokter->nama.' pada '.$this->setDate($oldTgl).' yang semula pukul *'.$this->setTime($oldJam).' WIB*, kami ubah menjadi pukul '.'*'.$this->setTime($datas->jam_jadwal).' WIB* dengan antrian nomor '.
            $antrian.'.'.PHP_EOL.PHP_EOL.'Lakukan pengecekan antrian secara berkala pada website karena sewaktu-waktu nomor antrian bisa berubah. Terima kasih.'
            .PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.
            '*Klinik Gigi Bara Senyum*'.PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';
        }else{
            $pesan = '*[PEMBERITAHUAN]*'.PHP_EOL.PHP_EOL.'Halo '.$datas->pasien->nama.'. Untuk jadwal kontrol dengan drg. '
            .$datas->dokter->nama.' yang semula pada '.$this->setDate($oldTgl).' pukul '.$this->setTime($oldJam).' WIB, kami ubah menjadi '.'*'.$this->setDate($datas->tgl_jadwal).'* pukul *'.$this->setTime($datas->jam_jadwal).
            ' WIB* dengan antrian nomor '.$antrian.'.'.PHP_EOL.PHP_EOL.'Lakukan pengecekan antrian secara berkala pada website karena sewaktu-waktu nomor antrian bisa berubah. Terima kasih.'
            .PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.
            '*Klinik Gigi Bara Senyum*'.PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';
        }

        // $response = Http::withHeaders(['Authorization' => 'zn#w4#AY8zmfdpnk6PJ8'])->post('https://api.fonnte.com/device');
        $response = Http::withHeaders([
            'Authorization' => 'zn#w4#AY8zmfdpnk6PJ8', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $datas->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        
        
        if ($response->ok()) {
            // $responseData = $response->json();
            $datas->pesan = $pesan;
            $datas->save();
            return redirect('jadwal-kontrol')->withSuccess('Data jadwal berhasil diubah.');
        } else {
            return redirect('jadwal-kontrol');
            $errorMessage = $response->body();
        }
    }

    public function cancelJadwal($id)
    {
        $datas = JadwalKontrol::find($id);
        $datas->update(['status' => 'Batal']);

        $pesan = '*[PEMBERITAHUAN]*'.PHP_EOL.PHP_EOL.'Halo '.$datas->pasien->nama.'. Kami memohon maaf untuk jadwal kontrol dengan drg. '
        .$datas->dokter->nama.' pada '.$this->setDate($datas->tgl_jadwal).' pukul '.$this->setTime($datas->jam_jadwal).' WIB kami batalkan.'.PHP_EOL.PHP_EOL.
        'Silakan menunggu jadwal terbaru atau dapat mengajukan reservasi jadwal kepada dokter gigi yang bersangkutan. Terima kasih.'
        .PHP_EOL.PHP_EOL.'____________________'.PHP_EOL.'*Klinik Gigi Bara Senyum*'.PHP_EOL.'Ruko Pondok Citra Eksekutif R2'.PHP_EOL.
        'Jl. Kendal Sari Selatan, Kec. Rungkut'.PHP_EOL.'Surabaya';

        // $response = Http::withHeaders(['Authorization' => 'zn#w4#AY8zmfdpnk6PJ8'])->post('https://api.fonnte.com/device');
        $response = Http::withHeaders([
            'Authorization' => 'zn#w4#AY8zmfdpnk6PJ8', 
        ])->post('https://api.fonnte.com/send', [
            'target' => $datas->pasien->no_hp,
            'message' => $pesan,
            'countryCode' => '62',
        ]);
        if ($response->ok()) {
            // $responseData = $response->json();
            $datas->pesan = $pesan;
            $datas->save();
            return redirect('jadwal-kontrol')->withSuccess('Data jadwal berhasil dibatalkan.');
        } else {
            return redirect('jadwal-kontrol');
            $errorMessage = $response->body();
        }
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
