<?php

namespace App\Http\Controllers;

use App\Models\JadwalKontrol;
use App\Models\JenisKonsultasi;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = RekamMedis::where('id_dokter', $id)->get();
        return view('dokter.rekam-medis.index', [
            'datas' => $datas,
            'title' => 'rekam-medis',
        ]);
    }

    public function viewJadwal()
    {
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = JadwalKontrol::where('id_dokter', $id)
        ->where('status', 'Selesai')
        ->get();

        return view('dokter.rekam-medis.list-jadwal',[
            'datas' => $datas,
            'title' => 'rekam-medis',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $datas = JadwalKontrol::find($id);
        $jenis = JenisKonsultasi::all();
        return view('dokter.rekam-medis.create', [
            'datas' => $datas,
            'jenis' => $jenis,
            'title' => 'rekam-medis',
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
            'id_jenis' => 'not_in:null',
            'odontogram' => 'required',
            'anamnesis' => 'required',
            'diagnosis' => 'required',
            'perawatan' => 'required',
        ]);
        RekamMedis::create([
            'id_dokter' => Auth::guard('dokter')->user()->id_dokter,
            'id_pasien' => $request['id_pasien'],
            'id_jenis' => $request['id_jenis'],
            'tgl_konsultasi' => $request['tgl_konsultasi'],
            'odontogram' => $request['odontogram'],
            'anamnesis' => $request['anamnesis'],
            'diagnosis' => $request['diagnosis'],
            'perawatan' => $request['perawatan'],
        ]);
        return redirect('rekam-medis')->withSuccess('Data rekam medis berhasil dibuat.');
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
