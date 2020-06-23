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
    Route::post('/surat/masuk/buat', 'TestingController@storeMailIn');
    Route::patch('/surat/masuk/{id}/update', 'TestingController@updateMailIn');

    Route::post('/pengguna/surat/jenis', 'TestingController@storeMailType');
    Route::patch('/pengguna/surat/jenis/{id}', 'TestingController@updateMailType');
    Route::delete('/pengguna/surat/jenis/{id}', 'TestingController@deleteMailType');
    Route::post('/pengguna/surat/sifat', 'TestingController@storeMailReference');
    Route::patch('/pengguna/surat/sifat/{id}', 'TestingController@updateMailReference');
    Route::delete('/pengguna/surat/sifat/{id}', 'TestingController@deleteMailReference');
    Route::post('/pengguna/surat/prioritas', 'TestingController@storeMailPriority');
    Route::patch('/pengguna/surat/prioritas/{id}', 'TestingController@updateMailPriority');
    Route::delete('/pengguna/surat/prioritas/{id}', 'TestingController@deleteMailPriority');

    // Mail Out
    Route::post('/surat/keluar', 'FathilTestingController@storeMailOut');

    // User
    Route::post('/pengguna', 'UserSettingController@storeUser');
    Route::patch('/pengguna/{id}', 'UserSettingController@updateUser');
    Route::delete('/pengguna/{id}', 'UserSettingController@deleteUser');

    // User Position
    Route::post('/pengguna/jabatan', 'UserSettingController@storeUserPosition');
    Route::patch('/pengguna/jabatan/{id}', 'UserSettingController@updateUserPosition');
    Route::delete('/pengguna/jabatan/{id}', 'UserSettingController@deleteUserPosition');

    // User Department
    Route::post('/pengguna/bidang', 'UserSettingController@storeUserDepartment');
    Route::patch('/pengguna/bidang/{id}', 'UserSettingController@updateUserDepartment');
    Route::delete('/pengguna/bidang/{id}', 'UserSettingController@deleteUserDepartment');

    // User Position Detail
    Route::post('/pengguna/unit-kerja', 'UserSettingController@storeUserPositionDetail');
    Route::patch('/pengguna/unit-kerja/{id}', 'UserSettingController@updateUserPositionDetail');
    Route::delete('/pengguna/unit-kerja/{id}', 'UserSettingController@deleteUserPositionDetail');
});

Route::get('/', 'FathilTestingController@temp');
