<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPraktik;
use Illuminate\Support\Facades\Auth;

class JadwalPraktikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::guard('dokter')->user()->id_dokter;
        $datas = JadwalPraktik::where('id_dokter', $id)->get();
        
        return view('dokter.praktik.index', [
            'title' => 'praktik',
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
        return view('dokter.praktik.create',[
            'title' => 'praktik',
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
            'hari' => 'required|not_in:null',
            // 'jam_kerja' => 'required',
        ]);

        $jamKerja = $request['jam_kerja1']." - ".$request['jam_kerja2'];
        // dd($request['id_dokter']);

        JadwalPraktik::create([
            'id_dokter' => $request['id_dokter'],
            'hari' => $request['hari'],
            'jam_kerja' => $jamKerja,
        ]);

        return redirect('jadwal-praktik');
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
