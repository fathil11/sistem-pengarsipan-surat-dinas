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
    Route::post('/pengguna/surat/tipe', 'TestingController@storeMailType');

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

Route::get('/', 'TestingController@tes');
