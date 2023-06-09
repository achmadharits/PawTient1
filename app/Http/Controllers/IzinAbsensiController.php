<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JadwalPraktik;
use Illuminate\Support\Facades\Auth;

class IzinAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = IzinAbsensi::where('id_dokter', $id)
        ->orderBy('tgl_izin', 'asc')
        ->get();
        return view('dokter.absensi.index', [
            'datas' => $datas,
            'title' => 'absensi',
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        return view('dokter.absensi.create', [
            'tanggal' => $tanggal->pluck('hari'),
            'title' => 'absensi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_izin' => 'required|date',
            'alasan' => 'required',
        ]);

        IzinAbsensi::create([
            'id_dokter' => $request->id_dokter,
            'tgl_izin' => $request->tgl_izin,
            'alasan' => $request->alasan,
        ]);
        return redirect('izin')->withSuccess('Perizinan berhasil dibuat');
    }

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
        $datas = IzinAbsensi::find($id);
        $datas->delete();
        return redirect('izin')->withSuccess('Data perizinan berhasil dihapus.');
    }
}
