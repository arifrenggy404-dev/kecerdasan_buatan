@extends('layouts.docs')
@section('title', 'Cara Penggunaan')

@section('content')
<div class="doc-card">
    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-3">Panduan Pengguna</span>
    <h1 class="display-6 fw-bold text-dark mb-4">Cara Menghasilkan Jadwal</h1>
    
    <p class="text-muted mb-5">
        Ikuti langkah-langkah di bawah ini secara berurutan untuk memastikan sistem dapat bekerja dengan maksimal.
    </p>

    <div class="d-flex mb-4">
        <div class="flex-shrink-0">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">1</div>
        </div>
        <div class="ms-3">
            <h6 class="fw-bold mb-1">Input Data Master</h6>
            <p class="small text-muted mb-0">Masukkan data Dosen, Gedung, dan Ruangan. Pastikan kapasitas ruangan mencukupi.</p>
        </div>
    </div>

    <div class="d-flex mb-4">
        <div class="flex-shrink-0">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">2</div>
        </div>
        <div class="ms-3">
            <h6 class="fw-bold mb-1">Input Mata Kuliah & Plotting</h6>
            <p class="small text-muted mb-0">Tambahkan mata kuliah dan tentukan dosen yang akan mengampu kelas tersebut di menu "Mata Kuliah".</p>
        </div>
    </div>

    <div class="d-flex mb-4">
        <div class="flex-shrink-0">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">3</div>
        </div>
        <div class="ms-3">
            <h6 class="fw-bold mb-1">Atur Parameter Waktu</h6>
            <p class="small text-muted mb-0">Buka "Pengaturan" untuk menentukan hari aktif kuliah dan jam operasional universitas.</p>
        </div>
    </div>

    <div class="d-flex mb-5">
        <div class="flex-shrink-0">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">4</div>
        </div>
        <div class="ms-3">
            <h6 class="fw-bold mb-1">Jalankan Penjadwalan</h6>
            <p class="small text-muted mb-0">Klik tombol "Jalankan Penjadwalan" di beranda. Sistem akan mencari solusi hingga ditemukan jadwal tanpa bentrok (Fitness 1.0).</p>
        </div>
    </div>

    <div class="alert alert-warning border-0 rounded-4 p-4">
        <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Catatan Penting</h6>
        <p class="small mb-0 opacity-75">Jika sistem berjalan terlalu lama, pastikan jumlah ruangan tersedia lebih banyak dari jumlah kelas yang berjalan di waktu yang sama.</p>
    </div>
</div>
@endsection
