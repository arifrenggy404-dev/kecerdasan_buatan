<?php

use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JadwalController::class, 'index'])->name('jadwal.index');
Route::post('/buat', [JadwalController::class, 'buat'])->name('jadwal.buat');
Route::delete('/jadwal/bersihkan', [JadwalController::class, 'hapusSemua'])->name('jadwal.bersihkan');
Route::get('/jadwal/ekspor/csv', [JadwalController::class, 'eksporCsv'])->name('jadwal.ekspor.csv');
Route::get('/jadwal/ekspor/pdf', [JadwalController::class, 'eksporPdf'])->name('jadwal.ekspor.pdf');

// Rute Dokumentasi
Route::prefix('dokumentasi')->group(function () {
    Route::get('/', [DokumentasiController::class, 'index'])->name('dokumentasi.index');
    Route::get('/penggunaan', [DokumentasiController::class, 'penggunaan'])->name('dokumentasi.penggunaan');
    Route::get('/algoritma', [DokumentasiController::class, 'algoritma'])->name('dokumentasi.algoritma');
    Route::get('/arsitektur', [DokumentasiController::class, 'arsitektur'])->name('dokumentasi.arsitektur');
    Route::get('/troubleshooting', [DokumentasiController::class, 'pemecahanMasalah'])->name('dokumentasi.troubleshooting');
    Route::get('/ekspor', [DokumentasiController::class, 'ekspor'])->name('dokumentasi.ekspor');
    Route::get('/faq', [DokumentasiController::class, 'faq'])->name('dokumentasi.faq');
});

Route::resource('dosen', DosenController::class)->only(['index', 'store', 'update', 'destroy'])->names('dosen');
Route::resource('gedung', GedungController::class)->only(['index', 'store', 'update', 'destroy'])->names('gedung');
Route::resource('ruangan', RuanganController::class)->only(['index', 'store', 'update', 'destroy'])->names('ruangan');
Route::resource('mata-kuliah', MataKuliahController::class)->only(['index', 'store', 'update', 'destroy'])->names('mata-kuliah');

Route::put('kelas/{kelas}', [MataKuliahController::class, 'updateOffering'])->name('kelas.update');
Route::delete('kelas/{kelas}', [MataKuliahController::class, 'destroyOffering'])->name('kelas.destroy');

Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
