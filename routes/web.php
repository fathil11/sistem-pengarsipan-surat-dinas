<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route for Testing
Route::group(['prefix' => 'test'], function () {
    Route::post('/surat/masuk/buat','TestingController@storeMailIn');
    Route::post('/pengguna/surat/tipe','TestingController@storeMailType');
    Route::post('/pengguna/jabatan', 'FathilTestingController@storeUserPosition');
    Route::post('/pengguna/bidang', 'FathilTestingController@storeUserDepartment');
    Route::post('/pengguna/unit-kerja', 'FathilTestingController@storeUserPositionDetail');
});

Route::get('/', function () {
    return view('welcome');
});
