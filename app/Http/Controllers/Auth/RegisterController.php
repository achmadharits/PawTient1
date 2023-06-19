<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'nama' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    public function index()
    {
        return view('auth.register');
    }

    public function getCustomIdDokter($id)
    {
        // return str_pad('D', 0, $id);
        if($id > 9){
            return 'D' . $id;
        }else{
            return 'D0' . $id;
        }
    }

    public function getCustomIdPasien($id)
    {
        // return str_pad('D', 0, $id);
        if($id > 9){
            return 'P' . $id;
        }else{
            return 'P0' . $id;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $id_dokter = Dokter::pluck('id_dokter')->count();
        $id_dokter = $this->getCustomIdDokter($id_dokter + 1);

        $id_pasien = Pasien::pluck('id_pasien')->count();
        $id_pasien = $this->getCustomIdPasien($id_pasien + 1);

        if($request['role'] == 'dokter gigi'){
            $this->validate($request, [
                'email' => ['required', 'string', 'unique:dokter'],
            ]);
            Dokter::create([
                'id_dokter' => $id_dokter,
                'nama' => $request['nama'],
                'email' => $request['email'],
                'no_hp' => $request['no_hp'],
                'password' => Hash::make($request['password']),
                'no_str' => $request['no_str'],
            ]);
        }elseif($request['role'] == 'pasien'){
            $this->validate($request, [
                'email' => ['required', 'string', 'unique:pasien'],
            ]);
            Pasien::create([
                'id_pasien' => $id_pasien,
                'nama' => $request['nama'],
                'email' => $request['email'],
                'no_hp' => $request['no_hp'],
                'password' => Hash::make($request['password']),
            ]);
        }else{
            User::create([
                'nama' => $request['nama'],
                'email' => $request['email'],
                'no_hp' => $request['no_hp'],
                'password' => Hash::make($request['password']),
            ]);
        }
        return redirect()->route('auth.index')->withSuccess('Akun berhasil dibuat! Silakan masuk ke akun');
        
    }
}
