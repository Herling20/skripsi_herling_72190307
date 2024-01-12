<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/adminauth.php';

Route::middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');
    //--- Halaman Profil ---//
    Route::get('/admin/profileAdmin', [AdminController::class, 'profileAdmin'])->name('admin.profil');
    Route::post('/admin/uploadFoto', [AdminController::class, 'uploadFoto'])->name('admin.uploadFoto');
    //--- Halaman Tahun Ajaran ---//
    Route::get('/admin/tahunAjaran', [AdminController::class, 'tahunAjaran'])->name('admin.tahunAjaran');
    Route::post('/admin/saveTahunAjaran', [AdminController::class, 'saveTahunAjaran'])->name('admin.saveTahunAjaran');
    Route::post('/admin/aktifTahunAjaran/{id}', [AdminController::class, 'aktifTahunAjaran'])->name('admin.aktifTahunAjaran');
    Route::post('/admin/editTahunAjaran/{id}', [AdminController::class, 'editTahunAjaran'])->name('admin.editTahunAjaran');
    Route::post('/admin/hapusTahunAjaran/{id}', [AdminController::class, 'hapusTahunAjaran'])->name('admin.hapusTahunAjaran');
    //--- Halaman Data Mahasiswa ---//
    Route::get('/admin/dataMahasiswa', [AdminController::class, 'dataMahasiswa'])->name('admin.dataMahasiswa');
    Route::get('/admin/detailDataMahasiswa/{id}', [AdminController::class, 'detailDataMahasiswa'])->name('admin.detailDataMahasiswa');
    Route::get('/admin/editDataMahasiswa/{id}', [AdminController::class, 'editDataMahasiswa'])->name('admin.editDataMahasiswa');
    Route::post('/admin/updateDataMahasiswa/{id}', [AdminController::class, 'updateDataMahasiswa'])->name('admin.updateDataMahasiswa');
    Route::post('/admin/hapusDataMahasiswa/{id}', [AdminController::class, 'hapusDataMahasiswa'])->name('admin.hapusDataMahasiswa');
    Route::get('/admin/tambahMahasiswa', [AdminController::class, 'tambahDataMahasiswa'])->name('admin.tambahDataMahasiswa');
    Route::post('/admin/saveDataMahasiswa', [AdminController::class, 'saveDataMahasiswa'])->name('admin.saveDataMahasiswa');
    //--- Halaman Data Dosen ---//
    Route::get('/admin/dataDosen', [AdminController::class, 'dataDosen'])->name('admin.dataDosen');
    Route::get('/admin/detailDataDosen/{id}', [AdminController::class, 'detailDataDosen'])->name('admin.detailDataDosen');
    Route::get('/admin/editDataDosen/{id}', [AdminController::class, 'editDataDosen'])->name('admin.editDataDosen');
    Route::post('/admin/updateDataDosen/{id}', [AdminController::class, 'updateDataDosen'])->name('admin.updateDataDosen');
    Route::post('/admin/hapusDataDosen/{id}', [AdminController::class, 'hapusDataDosen'])->name('admin.hapusDataDosen');
    Route::get('/admin/tambahDosen', [AdminController::class, 'tambahDataDosen'])->name('admin.tambahDataDosen');
    Route::post('/admin/saveDataDosen', [AdminController::class, 'saveDataDosen'])->name('admin.saveDataDosen');
});

require __DIR__.'/dosenauth.php';

Route::middleware(['auth:dosen', 'verified'])->group(function () {
    Route::get('/dosen/dashboard', [DosenController::class, 'dashboardDosen'])->name('dosen.dashboard');
    Route::get('/dosen/profileDosen', [DosenController::class, 'profileDosen'])->name('dosen.profil');
    Route::post('/dosen/uploadFoto', [DosenController::class, 'uploadFoto'])->name('dosen.uploadFoto');
    Route::get('/dosen/mahasiswaDosen', [DosenController::class, 'mahasiswaDosen'])->name('dosen.mahasiswa');
    Route::get('/dosen/detailMahasiswaDosen/{id}', [DosenController::class, 'detailMahasiswaDosen'])->name('dosen.detailMahasiswaDosen');
    //--- Halaman Milestone Dosen ---//
    Route::get('/dosen/milestoneDosen', [DosenController::class, 'milestoneDosen'])->name('dosen.milestone');
    Route::post('/dosen/editMilestone', [DosenController::class, 'editMilestone'])->name('editMlstn.dosen');
    Route::post('/dosen/milestoneDosen/saveMilestone', [DosenController::class, 'saveMilestone'])->name('saveMlstn.dosen');
    Route::post('/dosen/hapusMilestone/{id}', [DosenController::class, 'hapusMilestone'])->name('hapusMilestone.dosen');
    //--- Halaman Bimbingan Dosen ---//
    Route::get('/dosen/bimbinganDosen', [DosenController::class, 'bimbinganDosen'])->name('dosen.bimbingan');
    Route::post('/dosen/konfirmasiBimbingan', [DosenController::class, 'konfirmasiBimbingan'])->name('dosen.konfirmasiBimbingan');
    Route::post('/dosen/mulaiBimbingan/{id}', [DosenController::class, 'mulaiBimbingan'])->name('dosen.mulaiBimbingan');
    Route::post('/dosen/selesaiBimbingan', [DosenController::class, 'selesaiBimbingan'])->name('dosen.selesaiBimbingan');
    
});

require __DIR__.'/mahasiswaauth.php';

Route::middleware(['auth:mahasiswa', 'verified'])->group(function () {
    Route::get('/mahasiswa/home', [MahasiswaController::class, 'homeMahasiswa'])->name('mahasiswa.home');
    Route::get('/mahasiswa/profileMahasiswa', [MahasiswaController::class, 'profileMahasiswa'])->name('mahasiswa.profil');
    Route::get('/mahasiswa/milestoneMahasiswa', [MahasiswaController::class, 'milestoneMahasiswa'])->name('mahasiswa.milestone');
    Route::post('/mahasiswa/ajukanBimbingan', [MahasiswaController::class, 'ajukanBimbingan'])->name('mahasiswa.ajukanBimbingan');
    Route::post('/mahasiswa/uploadFoto', [MahasiswaController::class, 'uploadFoto'])->name('mahasiswa.uploadFoto');
    Route::get('/mahasiswa/cetakKonsultasi', [MahasiswaController::class, 'cetakKonsultasi'])->name('mahasiswa.cetakKonsultasi');
});
