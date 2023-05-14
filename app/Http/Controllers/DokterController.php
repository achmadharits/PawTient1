<?php

namespace App\Http\Controllers;

// use App\Http\Middleware\Dokter;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::guard('dokter')->user()->id_dokter;
        $datas = Dokter::find($user_id);

        // if (!$datas->nama || !$datas->email || !$datas->alamat || !$datas->no_hp) {
        //     return redirect()->back()->withErrors('Silahkan lengkapi profil terlebih dahulu!');
        // }        
        // dd($datas);
        return view('dokter.profil.index', [
            'datas' => $datas,
            'title' => 'profil',
        ]);
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
        $user = Auth::guard('dokter')->user()->id_dokter;
        $datas = Dokter::find($user);

        $datas->nama = $request->nama;
        $datas->alamat = $request->alamat;
        $datas->no_hp = $request->no_hp;

        $datas->save();
        return redirect('profil')->withSuccess('Profil berhasil diperbaharui');;
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
