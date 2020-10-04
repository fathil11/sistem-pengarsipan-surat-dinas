<?php

use App\User;
use App\Mail\TestMail;
use App\Mail\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Date;

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
// Route::group(['prefix' => 'test'], function () {
//     Route::post('/pengguna/surat/jenis', 'MailSettingController@storeMailType');
//     Route::patch('/pengguna/surat/jenis/{id}', 'MailSettingController@updateMailType');
//     Route::delete('/pengguna/surat/jenis/{id}', 'MailSettingController@deleteMailType');
//     Route::post('/pengguna/surat/sifat', 'MailSettingController@storeMailReference');
//     Route::patch('/pengguna/surat/sifat/{id}', 'MailSettingController@updateMailReference');
//     Route::delete('/pengguna/surat/sifat/{id}', 'MailSettingController@deleteMailReference');
//     Route::post('/pengguna/surat/prioritas', 'MailSettingController@storeMailPriority');
//     Route::patch('/pengguna/surat/prioritas/{id}', 'MailSettingController@updateMailPriority');
//     Route::delete('/pengguna/surat/prioritas/{id}', 'MailSettingController@deleteMailPriority');
//     Route::post('/pengguna/surat/berkas', 'MailSettingController@storeMailFolder');
//     Route::patch('/pengguna/surat/berkas/{id}', 'MailSettingController@updateMailFolder');
//     Route::delete('/pengguna/surat/berkas/{id}', 'MailSettingController@deleteMailFolder');

//     Route::post('/pengguna/surat/tipe-koreksi', 'MailSettingController@storeMailCorrectionType');
//     Route::patch('/pengguna/surat/tipe-koreksi/{id}', 'MailSettingController@updateMailCorrectionType');
//     Route::delete('/pengguna/surat/tipe-koreksi/{id}', 'MailSettingController@deleteMailCorrectionType');

//     // Mail Out
//     Route::post('/surat/keluar', 'MailController@storeMailOut');
//     Route::patch('/surat/keluar/{id}', 'MailController@updateMailOut');
//     Route::delete('/surat/keluar/{id}', 'MailController@deleteMailOut');
//     Route::patch('/surat/keluar/{id}/buat-nomor', 'MailController@storeNumber');

//     // User
//     Route::get('/lihat-pengguna', 'UserSettingController@showsUser');
//     Route::post('/pengguna', 'UserSettingController@storeUser');
//     Route::patch('/pengguna/{id}', 'UserSettingController@updateUser');
//     Route::delete('/pengguna/{id}', 'UserSettingController@deleteUser');

//     // User Position
//     Route::post('/pengguna/jabatan', 'UserSettingController@storeUserPosition');
//     Route::patch('/pengguna/jabatan/{id}', 'UserSettingController@updateUserPosition');
//     Route::delete('/pengguna/jabatan/{id}', 'UserSettingController@deleteUserPosition');

//     // User Department
//     Route::post('/pengguna/bidang', 'UserSettingController@storeUserDepartment');
//     Route::patch('/pengguna/bidang/{id}', 'UserSettingController@updateUserDepartment');
//     Route::delete('/pengguna/bidang/{id}', 'UserSettingController@deleteUserDepartment');

//     // User Position Detail
//     Route::post('/pengguna/unit-kerja', 'UserSettingController@storeUserPositionDetail');
//     Route::patch('/pengguna/unit-kerja/{id}', 'UserSettingController@updateUserPositionDetail');
//     Route::delete('/pengguna/unit-kerja/{id}', 'UserSettingController@deleteUserPositionDetail');
// });
Route::group(['middlware', 'auth'], function () {
    Route::get('/', 'HomeController@showDashboard');

    Route::group(['prefix' => 'pengguna'], function () {
        // User
        Route::get('/lihat', 'UserController@index')->name('user.index');
        Route::get('/', 'UserController@create')->name('user.create');
        Route::post('/', 'UserController@store')->name('user.store');
        Route::get('/{id}', 'UserController@edit')->name('user.edit');
        Route::patch('/{id}', 'UserController@update')->name('user.update');
        Route::delete('/{id}', 'UserController@destroy')->name('user.destroy');

        Route::group(['prefix' => 'pengaturan'], function () {

            Route::group(['prefix' => 'jabatan'], function () {
                Route::get('/', 'UserPositionController@index')->name('user.position.index');
                Route::get('/tambah', 'UserPositionController@create')->name('user.position.create');
                Route::post('/tambah', 'UserPositionController@store')->name('user.position.store');
                Route::get('/{id}', 'UserPositionController@edit')->name('user.position.edit');
                Route::patch('/{id}', 'UserPositionController@update')->name('user.position.update');
                Route::delete('/{id}', 'UserPositionController@destroy')->name('user.position.destroy');
            });

            Route::group(['prefix' => 'bidang'], function () {
                Route::get('/', 'UserDepartmentController@index')->name('user.department.index');
                Route::get('/tambah', 'UserDepartmentController@create')->name('user.department.create');
                Route::post('/tambah', 'UserDepartmentController@store')->name('user.department.store');
                Route::get('/{id}', 'UserDepartmentController@edit')->name('user.department.edit');
                Route::patch('/{id}', 'UserDepartmentController@update')->name('user.department.update');
                Route::delete('/{id}', 'UserDepartmentController@destroy')->name('user.department.destroy');
            });

            Route::group(['prefix' => 'unit-kerja'], function () {
                Route::get('/', 'UserPositionDetailController@index')->name('user.position-detail.index');
                Route::get('/tambah', 'UserPositionDetailController@create')->name('user.position-detail.create');
                Route::post('/tambah', 'UserPositionDetailController@store')->name('user.position-detail.store');
                Route::get('/{id}', 'UserPositionDetailController@edit')->name('user.position-detail.edit');
                Route::patch('/{id}', 'UserPositionDetailController@update')->name('user.position-detail.update');
                Route::delete('/{id}', 'UserPositionDetailController@destroy')->name('user.position-detail.destroy');
            });

        });

    });

    Route::group(['prefix' => 'surat'], function () {
        //Mail In Route
        Route::group(['prefix' => 'masuk'], function () {
            Route::get('/', 'MailInController@index')->name('mail.out.index');
            Route::get('/buat', 'MailInController@create')->name('mail.out.create');
            Route::post('/', 'MailInController@store')->name('mail.out.store');
            Route::get('/{id}', 'MailInController@show')->name('mail.out.show');
            Route::patch('/{id}', 'MailInController@update')->name('mail.out.update');
            Route::delete('/{id}', 'MailInController@destroy')->name('mail.out.destroy');
            Route::post('/{id}/download', 'MailInController@download')->name('mail.out.download');
            Route::patch('/{id}/download-disposisi', 'MailInController@downloadDisposition')->name('mail.out.downloadDisposition');
            Route::get('/{id}/teruskan', 'MailInController@showProcess')->name('mail.out.showProcess');
            Route::patch('/{id}/teruskan', 'MailInController@forward')->name('mail.out.forward');
            Route::get('/{id}/disposisi', 'MailInController@showProcess')->name('mail.out.showProcess');
            Route::patch('/{id}/disposisi', 'MailInController@disposition')->name('mail.out.disposition');
            Route::patch('/{id}/arsip', 'MailInController@archive')->name('mail.out.archive');
        });

        //Mail Out Route
        Route::group(['prefix' => 'keluar'], function () {
            Route::get('/', 'MailOutController@index')->name('mail.out.index');
            Route::get('/buat', 'MailOutController@create')->name('mail.out.create');
            Route::post('/', 'MailOutController@store')->name('mail.out.store');
            Route::get('/{id}', 'MailOutController@show')->name('mail.out.show');
            Route::get('/{id}/koreksi', 'MailOutController@edit')->name('mail.out.edit');
            Route::patch('/{id}/koreksi', 'MailOutController@update')->name('mail.out.update');
            Route::delete('/{id}', 'MailOutController@destroy')->name('mail.out.destroy');
            Route::get('/{id}/arsip', 'MailOutController@archive')->name('mail.out.archive');
            Route::post('/{id}/download', 'MailOutController@download')->name('mail.out.download');
            Route::patch('/{id}/teruskan', 'MailOutController@forward')->name('mail.out.forward');
            Route::patch('/{id}/buat-koreksi', 'MailOutController@createCorrection')->name('mail.out.createCorrection');
            Route::patch('/{id}/buat-nomor', 'MailOutController@storeNumber')->name('mail.out.storeNumber');
        });

        Route::group(['prefix' => 'pengaturan'], function () {
            Route::group(['prefix' => 'jenis-surat'], function () {
                Route::get('/', 'MailTypeController@index')->name('mail.type.index');
                Route::get('/tambah', 'MailTypeController@create')->name('mail.type.create');
                Route::post('/tambah', 'MailTypeController@store')->name('mail.type.store');
                Route::get('/{id}', 'MailTypeController@edit')->name('mail.type.edit');
                Route::patch('/{id}', 'MailTypeController@update')->name('mail.type.update');
                Route::delete('/{id}', 'MailTypeController@destroy')->name('mail.type.destroy');
            });

            Route::group(['prefix' => 'sifat-surat'], function () {
                Route::get('/', 'MailReferenceController@index')->name('mail.reference.index');
                Route::get('/tambah', 'MailReferenceController@create')->name('mail.reference.create');
                Route::post('/tambah', 'MailReferenceController@store')->name('mail.reference.store');
                Route::get('/{id}', 'MailReferenceController@edit')->name('mail.reference.edit');
                Route::patch('/{id}', 'MailReferenceController@update')->name('mail.reference.update');
                Route::delete('/{id}', 'MailReferenceController@destroy')->name('mail.reference.destroy');
            });

            Route::group(['prefix' => 'prioritas-surat'], function () {
                Route::get('/', 'MailPriorityController@index')->name('mail.priority.index');
                Route::get('/tambah', 'MailPriorityController@create')->name('mail.priority.create');
                Route::post('/tambah', 'MailPriorityController@store')->name('mail.priority.store');
                Route::get('/{id}', 'MailPriorityController@edit')->name('mail.priority.edit');
                Route::patch('/{id}', 'MailPriorityController@update')->name('mail.priority.update');
                Route::delete('/{id}', 'MailPriorityController@destroy')->name('mail.priority.destroy');
            });

            Route::group(['prefix' => 'folder-surat'], function () {
                Route::get('/', 'MailFolderController@index')->name('mail.folder.index');
                Route::get('/tambah', 'MailFolderController@create')->name('mail.folder.create');
                Route::post('/tambah', 'MailFolderController@store')->name('mail.folder.store');
                Route::get('/{id}', 'MailFolderController@edit')->name('mail.folder.edit');
                Route::patch('/{id}', 'MailFolderController@update')->name('mail.folder.update');
                Route::delete('/{id}', 'MailFolderController@destroy')->name('mail.folder.destroy');
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

        Route::group(['prefix' => 'semua'], function () {
            Route::get('/masuk', 'TestingController@mailInList');
            Route::get('/keluar', 'TestingController@mailOutList');

            Route::group(['prefix' => 'arsip'], function () {

                Route::group(['prefix' => 'api'], function () {
                    Route::get('/semua', 'TestingController@jsonMailArchiveAll')->name('json.mail.archive.all');
                    Route::get('/surat-masuk', 'TestingController@jsonMailArchiveMailIn')->name('json.mail.archive.mail.in');
                    Route::get('/surat-keluar', 'TestingController@jsonMailArchiveMailOut')->name('json.mail.archive.mail.out');
                    Route::get('/tahun/{year}', 'TestingController@jsonMailArchiveYear')->name('json.mail.archive.year');
                });

                Route::get('/', 'TestingController@showMailArchiveFolder')->name('mail.archive.folder');
                Route::get('/semua', 'TestingController@showMailArchiveAll')->name('mail.archive.all');
                Route::get('/surat-masuk', 'TestingController@showMailArchiveMailIn')->name('mail.archive.mail.in');
                Route::get('/surat-keluar', 'TestingController@showMailArchiveMailOut')->name('mail.archive.mail.out');
                Route::get('/tahun', 'TestingController@showMailArchiveFolderYear')->name('mail.archive.folder.year');
                Route::get('/tahun/{year}', 'TestingController@showMailArchiveYear')->name('mail.archive.year');
            });
        });
    });
});

// Route::get('/surat/masuk/semua', 'TestingController@mailInList');
// Route::get('/surat/keluar/semua', 'TestingController@mailOutList');
// Route::get('/surat/arsip', 'TestingController@showMailArchiveYear');
// Route::get('/surat/arsip/{year}', 'TestingController@showMailArchive');


// Route::get('/surat/masuk', 'FathilTestingController@showMailInList');
// Route::get('/surat/masuk/{id}', 'MailController@showMailIn');
// Route::get('/surat/masuk/{id}/teruskan', 'TestingController@showProcessMailIn');
// Route::patch('/surat/masuk/{id}/teruskan', 'MailController@forwardMailIn');
// Route::get('/surat/masuk/{id}/disposisi', 'TestingController@showProcessMailIn');
// Route::patch('/surat/masuk/{id}/disposisi', 'MailController@dispositionMailIn');


// Route::post('/surat/masuk/{id}/download', 'MailController@downloadDispositionMailIn');

// Route::get('/test', 'FathilTestingController@test');
// Route::get('/tes', 'TestingController@tes');

// Authentication Routes...
Route::get('/masuk', function () {
    return view('app.login');
})->name('login');

Route::post('/masuk', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', function () {
    session()->flush();
    return redirect('/masuk');
});
