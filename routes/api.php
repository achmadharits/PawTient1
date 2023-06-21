<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiJadwalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('jadwal/{id}/{tanggal}', [ApiJadwalController::class, 'getHari']);
Route::get('data-jadwal/{id}/{tanggal}', [ApiJadwalController::class, 'getJadwal']);
// Route::resource('jadwal', ApiJadwalController::class);


// class ApiJadwalController extends Controller
// {
//     function getJadwalPraktik() {
//         $jadwal = JadwalPraktik::all();
//         return $jadwal;
//     }
// }