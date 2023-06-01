<?php

namespace App\Http\Controllers\Pasien;

use Carbon\Carbon;
use App\Models\Dokter;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Models\JadwalPraktik;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasienReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //disini langsung nampung id dokter
        $id = Auth::guard('pasien')->user()->id_pasien;
        $datas = Reservasi::where('id_pasien', $id)->get();
        return view('pasien.reservasi.index', [
            'title' => 'reservasi',
            'datas' => $datas,
        ]);
    }

    public function viewDokter()
    {
        $datas = Dokter::all();
        return view('pasien.reservasi.list-dokter',[
            'datas' => $datas,
            'title' => 'reservasi',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // $dokter = Dokter::find($id)->first()->id_dokter;
        $datas = Dokter::find($id);
        $tanggal = JadwalPraktik::where('id_dokter', $datas->id_dokter)->get();

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

        return view('pasien.reservasi.create', [
            'title' => 'reservasi',
            'datas' => $datas,
            'tanggal' => $tanggal->pluck('hari'),
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
        // change date format
        $newTgl = Carbon::createFromFormat('Y/m/d', $request['tgl_reservasi'])->format('Y-m-d');

        Reservasi::create([
            'id_dokter' => $request['id_dokter'],
            'id_pasien' => $request['id_pasien'],
            'tgl_reservasi' => $newTgl,
            'deskripsi' => $request['deskripsi'],
            'status' => 'Menunggu',
        ]);
        return redirect()->route('pasien.reservasi.index')->withSuccess('Reservasi berhasil dibuat');
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
