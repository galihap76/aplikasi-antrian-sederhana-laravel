<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Antrian;


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

Route::get('/', function () {
    return view('welcome');
});

// |----------------------[APP]----------------------|
Route::get('/app', [Authentication::class, 'app'])->middleware('auth:m_auth');

// |----------------------[LOGIN]----------------------|
Route::get('login', [Authentication::class, 'index'])->name('login')->middleware('guest');

// |----------------------[PROSES LOGIN]----------------------|
Route::post('proses_login', [Authentication::class, 'proses_login']);

// |----------------------[REGISTRASI]----------------------|
Route::get('registrasi', [Authentication::class, 'registrasi'])->middleware('guest');

// |----------------------[PROSES REGISTRASI]----------------------|
Route::post('proses_registrasi', [Authentication::class, 'proses_registrasi']);

// |----------------------[LUPA PASSWORD]----------------------|
Route::get('lupa_password', [Authentication::class, 'lupa_password']);

// |----------------------[PROSES LUPA PASSWORD]----------------------|
Route::post('proses_lupa_password', [Authentication::class, 'proses_lupa_password']);

// |----------------------[LOGOUT]----------------------|
Route::get('/logout', [Authentication::class, 'logout']);

// |----------------------[UPDATE ANTRIAN]----------------------|
Route::post('/update-antrian', [Antrian::class, 'updateAntrian']);

// |----------------------[GET ANTRIAN]----------------------|
Route::get('get_antrian', [Antrian::class, 'getAntrian']);

