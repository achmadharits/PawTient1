<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('dokter')->check()){
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
        }elseif(Auth::guard('pasien')->check()){
            $user_id = Auth::guard('pasien')->user()->id_pasien;
            $datas = Pasien::find($user_id);

            return view('pasien.profil.index', [
                'datas' => $datas,
                'title' => 'profil',
            ]);
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
        $this->validate($request, [
            'nama' => 'required',
            'no_hp' => 'required|numeric',
        ]);
        if(Auth::guard('dokter')->check()){
            $user = Auth::guard('dokter')->user()->id_dokter;
            $datas = Dokter::find($user);

            $datas->nama = $request->nama;
            $datas->alamat = $request->alamat;
            $datas->no_hp = $request->no_hp;

            $datas->save();
            return redirect('profil')->withSuccess('Profil berhasil diperbaharui');
        }elseif(Auth::guard('pasien')->check()){
            $user = Auth::guard('pasien')->user()->id_pasien;
            $datas = Pasien::find($user);

            $datas->nama = $request->nama;
            $datas->alamat = $request->alamat;
            $datas->usia = $request->usia;
            $datas->no_hp = $request->no_hp;

            $datas->save();
            return redirect('profil')->withSuccess('Profil berhasil diperbaharui');
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
        //
    }
}
