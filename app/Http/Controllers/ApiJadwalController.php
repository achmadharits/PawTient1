<?php

namespace App\Http\Controllers;

use App\Models\JadwalKontrol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JadwalPraktik;

class ApiJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = JadwalPraktik::all();
        return [
            'jadwal' => $jadwal,
        ];
    }

    function getHari($id, $tanggal) {
        $day = Carbon::createFromFormat('Y-m-d', $tanggal)->translatedFormat('l');
        $jadwal = JadwalPraktik::where('id_dokter', $id)
        ->where('hari', $day)
        ->pluck('jam_kerja');

        return [
            'jadwal' => $jadwal,
        ];
    }

    function setDate($date){
        Carbon::setLocale('id');
        Carbon::parse($date)->translatedFormat('l, d F Y');
    }
    function timeFormat($time){
        Carbon::parse($time)->format('H:i');
    }
    function getJadwal($id, $tanggal){
        $jadwal = JadwalKontrol::where('id_dokter', $id)
        ->where('tgl_jadwal', $tanggal)
        ->join('pasien', 'jadwalkontrol.id_pasien', '=', 'pasien.id_pasien')
        ->orderBy('antrian')
        ->select('antrian','pasien.nama','jam_jadwal')
        ->get();

        // $jadwal->jam_jadwal = Carbon::parse($jadwal->jam_jadwal)->format('H:i');

        return [
            'jadwal' => $jadwal,
        ];
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
    public function store(Request $request)
    {
        //
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
        //
    }
}
