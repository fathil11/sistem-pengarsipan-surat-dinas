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
    // Mail In === CRUD ===
    Route::post('/surat/masuk/', 'TestingController@storeMailIn');
    Route::patch('/surat/masuk/{id}', 'TestingController@updateMailIn');
    Route::delete('/surat/masuk/{id}', 'TestingController@deleteMailIn');

    //Mail In === Process ===
    Route::post('/surat/masuk/{id}/teruskan', 'TestingController@forwardMailIn');
    Route::post('/surat/masuk/{id}/disposisi', 'TestingController@dispositionMailIn');


    Route::post('/pengguna/surat/jenis', 'MailSettingController@storeMailType');
    Route::patch('/pengguna/surat/jenis/{id}', 'MailSettingController@updateMailType');
    Route::delete('/pengguna/surat/jenis/{id}', 'MailSettingController@deleteMailType');
    Route::post('/pengguna/surat/sifat', 'MailSettingController@storeMailReference');
    Route::patch('/pengguna/surat/sifat/{id}', 'MailSettingController@updateMailReference');
    Route::delete('/pengguna/surat/sifat/{id}', 'MailSettingController@deleteMailReference');
    Route::post('/pengguna/surat/prioritas', 'MailSettingController@storeMailPriority');
    Route::patch('/pengguna/surat/prioritas/{id}', 'MailSettingController@updateMailPriority');
    Route::delete('/pengguna/surat/prioritas/{id}', 'MailSettingController@deleteMailPriority');
    Route::post('/pengguna/surat/berkas', 'MailSettingController@storeMailFolder');
    Route::patch('/pengguna/surat/berkas/{id}', 'MailSettingController@updateMailFolder');
    Route::delete('/pengguna/surat/berkas/{id}', 'MailSettingController@deleteMailFolder');

    Route::post('/pengguna/surat/tipe-koreksi', 'MailSettingController@storeMailCorrectionType');
    Route::patch('/pengguna/surat/tipe-koreksi/{id}', 'MailSettingController@updateMailCorrectionType');
    Route::delete('/pengguna/surat/tipe-koreksi/{id}', 'MailSettingController@deleteMailCorrectionType');

    // Mail Out
    Route::post('/surat/keluar', 'MailController@storeMailOut');
    Route::patch('/surat/keluar/{id}', 'MailController@updateMailOut');
    Route::delete('/surat/keluar/{id}', 'MailController@deleteMailOut');

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

Route::get('/', 'FathilTestingController@test');
// Route::get('/', 'FathilTestingController@showDashboard');
Route::get('/surat/keluar', 'FathilTestingController@showMailOutList');
Route::get('/test', 'FathilTestingController@test');
