<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JadwalPraktikController;
use App\Http\Controllers\Dokter\DokterJadwalKontrolController;
use App\Http\Controllers\Dokter\DokterReservasiController;
use App\Http\Controllers\IzinAbsensiController;
use App\Http\Controllers\ListPasienController;
use App\Http\Controllers\Pasien\PasienReservasiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//  Syntax penulisan route 
/*
Route::method('/url', [namaController::ckass, 'namaFungsi'])->name('namaName')->middleware('namaMiddleware / nilainya')

method sendiri ada 4 yaitu get,post, put, dan delete

name() itu fungsi untuk memberi nama route biasanya digunakan pada saat kita mengisi link form ataupun tag href
contoh nya yaitu <a href="{{ route('namaRoute') }}" /> 
nah di routenya harus diberi nama yang sesuai yaitu ->name('namaRoute')

horee
*/

Route::get('/', function () {
    return view('welcome');
});


//Route juga bisa dikelompokkan contohnya macam route dibawah ini
//route dibawah ini hasilnya nanti setiap nama routenya diawali auth.namaRoute
Route::name('auth.')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('index')->middleware(['guest:dokter,pasien']);
    Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware(['guest:dokter,pasien']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::name('register.')->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('index')->middleware(['guest:dokter,pasien']);
    Route::post('/register', [RegisterController::class, 'create'])->name('create')->middleware(['guest:dokter,pasien']);
});

// route pasien
Route::prefix('pasien')->name('pasien.')->middleware('auth:pasien')->group(function () {
    Route::get('reservasi/dokter', [PasienReservasiController::class, 'viewDokter'])->name('dokter');
    Route::get('reservasi/{id}/create', [PasienReservasiController::class, 'create']);
    Route::resource('reservasi', PasienReservasiController::class)->except(['create']);
});

Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);

Route::middleware('auth:dokter')->group(function () {
    Route::resource('jadwal-kontrol', DokterJadwalKontrolController::class);
    Route::post('jadwal-kontrol/cancel/{id}', [DokterJadwalKontrolController::class, 'cancelJadwal']);
    Route::resource('jadwal-praktik', JadwalPraktikController::class);
    Route::resource('pasien', ListPasienController::class);
    Route::get('rekam-medis/{id}/create', [RekamMedisController::class, 'create']);
    Route::get('rekam-medis/jadwal', [RekamMedisController::class, 'viewJadwal']);
    Route::resource('rekam-medis', RekamMedisController::class);
    Route::prefix('dokter')->name('dokter.')->group(function () {
        Route::post('reservasi/save/{id}', [DokterReservasiController::class, 'saveJadwal']);
        Route::post('reservasi/tolak/{id}', [DokterReservasiController::class, 'declineJadwal']);
        Route::resource('reservasi', DokterReservasiController::class);
    });
    Route::resource('izin', IzinAbsensiController::class);
});

// edit profile
Route::resource('profil', ProfilController::class)->middleware('auth:pasien,dokter');




// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth:pasien,dokter');  // ini kan middlewarenya pertama kali pengecekan ke dokter
//sedangkan di middleware yang pertama kali dia itu ngecek pasien
// jadi urutannya harus sesuai yaitu pasien dulu baru dokter

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
