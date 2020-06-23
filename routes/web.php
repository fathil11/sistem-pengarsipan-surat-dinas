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
    Route::patch('/surat/masuk/{id}/update','TestingController@updateMailIn');

    Route::post('/pengguna/surat/jenis','TestingController@storeMailType');
    Route::patch('/pengguna/surat/jenis/{id}','TestingController@updateMailType');
    Route::delete('/pengguna/surat/jenis/{id}','TestingController@deleteMailType');
    Route::post('/pengguna/surat/sifat','TestingController@storeMailReference');
    Route::patch('/pengguna/surat/sifat/{id}','TestingController@updateMailReference');
    Route::delete('/pengguna/surat/sifat/{id}','TestingController@deleteMailReference');
    Route::post('/pengguna/surat/prioritas','TestingController@storeMailPriority');
    Route::patch('/pengguna/surat/prioritas/{id}','TestingController@updateMailPriority');
    Route::delete('/pengguna/surat/prioritas/{id}','TestingController@deleteMailPriority');

    // User
    Route::post('/pengguna', 'FathilTestingController@storeUser');

    // User Position
    Route::post('/pengguna/jabatan', 'FathilTestingController@storeUserPosition');
    Route::patch('/pengguna/jabatan/{id}', 'FathilTestingController@updateUserPosition');
    Route::delete('/pengguna/jabatan/{id}', 'FathilTestingController@deleteUserPosition');

    // User Department
    Route::post('/pengguna/bidang', 'FathilTestingController@storeUserDepartment');
    Route::patch('/pengguna/bidang/{id}', 'FathilTestingController@updateUserDepartment');
    Route::delete('/pengguna/bidang/{id}', 'FathilTestingController@deleteUserDepartment');

    // User Position Detail
    Route::post('/pengguna/unit-kerja', 'FathilTestingController@storeUserPositionDetail');
    Route::patch('/pengguna/unit-kerja/{id}', 'FathilTestingController@updateUserPositionDetail');
    Route::delete('/pengguna/unit-kerja/{id}', 'FathilTestingController@deleteUserPositionDetail');
});

Route::get('/', 'TestingController@tes');
