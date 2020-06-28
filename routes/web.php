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
    Route::post('/surat/masuk/', 'MailController@storeMailIn');
    Route::patch('/surat/masuk/{id}', 'MailController@updateMailIn');
    Route::delete('/surat/masuk/{id}', 'MailController@deleteMailIn');

    //Mail In === Process ===
    Route::post('/surat/masuk/{id}/teruskan', 'MailController@forwardMailIn');
    Route::post('/surat/masuk/{id}/disposisi', 'MailController@dispositionMailIn');


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
    Route::get('/lihat-pengguna', 'UserSettingController@showsUser');
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

Route::group(['prefix' => 'pengguna'], function () {
    // User
    Route::get('/lihat', 'UserSettingController@showUsers');
    Route::get('/', 'UserSettingController@createUser');
    Route::post('/', 'UserSettingController@storeUser');
    Route::get('/{id}', 'UserSettingController@editUser');
    Route::patch('/{id}', 'UserSettingController@updateUser');
    Route::delete('/{id}', 'UserSettingController@deleteUser');

    Route::group(['prefix' => 'pengaturan'], function () {
        Route::group(['prefix' => 'jabatan'], function () {
            Route::get('/', 'UserSettingController@showUsersPosition');
            Route::get('/tambah', 'UserSettingController@createUserPosition');
            Route::post('/tambah', 'UserSettingController@storeUserPosition');
            Route::get('/{id}', 'UserSettingController@editUserPosition');
            Route::patch('/{id}', 'UserSettingController@updateUserPosition');
            Route::delete('/{id}', 'UserSettingController@deleteUserPosition');
        });
        Route::group(['prefix' => 'unit-kerja'], function () {
            Route::get('/', 'UserSettingController@showUsersPositionDetail');
            Route::get('/tambah', 'UserSettingController@createUserPositionDetail');
            Route::post('/tambah', 'UserSettingController@storeUserPositionDetail');
            Route::get('/{id}', 'UserSettingController@editUserPositionDetail');
            Route::patch('/{id}', 'UserSettingController@updateUserPositionDetail');
            Route::delete('/{id}', 'UserSettingController@deleteUserPositionDetail');
        });
        Route::group(['prefix' => 'bidang'], function () {
            Route::get('/', 'UserSettingController@showUsersDepartment');
            Route::get('/tambah', 'UserSettingController@createUserDepartment');
            Route::post('/tambah', 'UserSettingController@storeUserDepartment');
            Route::get('/{id}', 'UserSettingController@editUserDepartment');
            Route::patch('/{id}', 'UserSettingController@updateUserDepartment');
            Route::delete('/{id}', 'UserSettingController@deleteUserDepartment');
        });
    });
});

Route::group(['prefix' => 'surat'], function () {
    Route::group(['prefix' => 'pengaturan'], function () {
        Route::group(['prefix' => 'jenis-surat'], function () {
            Route::get('/', 'MailSettingController@showMailsType');
            Route::get('/tambah', 'MailSettingController@createMailType');
            Route::post('/tambah', 'MailSettingController@storeMailType');
            Route::get('/{id}', 'MailSettingController@editMailType');
            Route::patch('/{id}', 'MailSettingController@updateMailType');
            Route::delete('/{id}', 'MailSettingController@deleteMailType');
        });
        Route::group(['prefix' => 'sifat-surat'], function () {
            Route::get('/', 'MailSettingController@showMailsReference');
            Route::get('/tambah', 'MailSettingController@createMailReference');
            Route::post('/tambah', 'MailSettingController@storeMailReference');
            Route::get('/{id}', 'MailSettingController@editMailReference');
            Route::patch('/{id}', 'MailSettingController@updateMailReference');
            Route::delete('/{id}', 'MailSettingController@deleteMailReference');
        });
        Route::group(['prefix' => 'prioritas-surat'], function () {
            Route::get('/', 'MailSettingController@showMailsPriority');
            Route::get('/tambah', 'MailSettingController@createMailPriority');
            Route::post('/tambah', 'MailSettingController@storeMailPriority');
            Route::get('/{id}', 'MailSettingController@editMailPriority');
            Route::patch('/{id}', 'MailSettingController@updateMailPriority');
            Route::delete('/{id}', 'MailSettingController@deleteMailPriority');
        });
        Route::group(['prefix' => 'folder-surat'], function () {
            Route::get('/', 'MailSettingController@showMailsFolder');
            Route::get('/tambah', 'MailSettingController@createMailFolder');
            Route::post('/tambah', 'MailSettingController@storeMailFolder');
            Route::get('/{id}', 'MailSettingController@editMailFolder');
            Route::patch('/{id}', 'MailSettingController@updateMailFolder');
            Route::delete('/{id}', 'MailSettingController@deleteMailFolder');
        });
        Route::group(['prefix' => 'tipe-koreksi'], function () {
            Route::get('/', 'MailSettingController@showMailsCorrectionType');
            Route::get('/tambah', 'MailSettingController@createMailCorrectionType');
            Route::post('/tambah', 'MailSettingController@storeMailCorrectionType');
            Route::get('/{id}', 'MailSettingController@editMailCorrectionType');
            Route::patch('/{id}', 'MailSettingController@updateMailCorrectionType');
            Route::delete('/{id}', 'MailSettingController@deleteMailCorrectionType');
        });
    });
});

Route::patch('/surat/keluar/{id}/teruskan', 'FathilTestingController@forwardMailOut');
Route::get('/', 'FathilTestingController@showDashboard');
Route::patch('/surat/keluar/{id}/buat-koreksi', 'FathilTestingController@createCorrection');
Route::get('/surat/keluar/{id}/koreksi', 'FathilTestingController@showMailOutCorrection');
Route::patch('/surat/keluar/{id}/koreksi', 'FathilTestingController@updateMailOut');

Route::get('/surat/masuk/semua', 'TestingController@mailInList');
Route::get('/surat/keluar/semua', 'TestingController@mailOutList');
Route::get('/surat/arsip', 'TestingController@showMailArchiveYear');
Route::get('/surat/arsip/{year}', 'TestingController@showMailArchive');


Route::get('/surat/masuk', 'FathilTestingController@showMailInList');
Route::get('/surat/masuk/{id}', 'MailController@showMailIn');
Route::get('/surat/masuk/{id}/teruskan', 'TestingController@showProcessMailIn');
Route::patch('/surat/masuk/{id}/teruskan', 'MailController@forwardMailIn');
Route::get('/surat/masuk/{id}/disposisi', 'TestingController@showProcessMailIn');
Route::patch('/surat/masuk/{id}/disposisi', 'MailController@dispositionMailIn');


Route::get('/surat/keluar', 'FathilTestingController@showMailOutList');
Route::get('/surat/keluar/{id}', 'FathilTestingController@showMailOut');
Route::post('/surat/keluar/{id}/download', 'FathilTestingController@downloadMailOut');
Route::patch('/surat/masuk/{id}/download', 'MailController@downloadDispositionMailIn');

Route::get('/test', 'FathilTestingController@test');
Route::get('/tes', 'TestingController@tes');
