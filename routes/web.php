<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'],function(){

    Route::get('/tambah-siswa','StudentsController@create')->name('tambahSiswa');

    Route::get('/data-siswa','StudentsController@dataSiswaExcel')->name('dataSiswa');

    Route::post('/tambah-siswa/progress','StudentsController@store')->name('tambahSiswa');

    Route::post('/import-dataSiswa','StudentsController@import')->name('importDataSiswa');

    Route::get('/jurusan-students/{jurusan}','StudentsController@jurusan')->name('halamanJurusan');

    Route::get('/detail/{student}/{NISN}','StudentsController@show')->name('detailSiswa');

    Route::post('/search-dataSiswa/{jurusan}','StudentsController@search')->name('cariSiswa');

    Route::get('/update-data/{student}','StudentsController@edit')->name('updateSiswa');

    Route::patch('/update-data/progress/{student}','StudentsController@update')->name('prosesUpdateSiswa');

    Route::delete('/delete-data/{student}','StudentsController@destroy')->name('hapusDataSiswa');

    Route::get('/exportDataSiswa/{jurusan}/{kelas}/XLS','StudentsController@exportExcel')->name('exportsiswaEXCEL');

    Route::get('/exportDataSiswa/{jurusan}/{kelas}/PDF','StudentsController@exportPDF')->name('exportsiswaPDF');

    Route::post('/tambahPembayaranAdministrasi/{NISN}','AdministrasiController@store')->name('TambahAdministrasi');

    Route::delete('/Hapus-Administrasi/{administrasi}','AdministrasiController@destroy')->name('HapusAdministrasi');

    Route::get('/exportAdministrasi/{nama}/{NISN}','AdministrasiController@exportAdministrasi')->name('ExportAdministrasi');

});
