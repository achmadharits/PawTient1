<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('dokter')->attempt($credentials)) {
            // dd("dokter");
            $request->session()->regenerate();
            
            return redirect()->intended('/home');
        }

        if (Auth::guard('pasien')->attempt($credentials)) {
            // dd("masuk sebagai pasie");
            $request->session()->regenerate();
            
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        // dd("logout");
        if (Auth::guard('dokter')->check()) {
            // dd("dokter");
            Auth::guard('dokter')->logout();
        } else if (Auth::guard('pasien')->check()) {
            // dd("pasien");
            Auth::guard('pasien')->logout();
        } else {
            // dd('gak terdeteksi guardnya');
            Auth::logout();
        }
        return redirect('/');
    }

    // use AuthenticatesUsers;

    // /**
    //  * Where to redirect users after login.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
}
