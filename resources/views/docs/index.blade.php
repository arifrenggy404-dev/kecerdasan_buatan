@extends('layouts.docs')
@section('title', 'Pengantar')

@section('content')
<div class="doc-card">
    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">Selamat Datang</span>
    <h1 class="display-5 fw-bold text-dark mb-4">Sistem Penjadwalan Universitas</h1>
    
    <p class="lead text-muted mb-4">
        Aplikasi berbasis Laravel untuk menghasilkan jadwal perkuliahan otomatis tanpa bentrok menggunakan optimasi Algoritma Genetika. 
    </p>
    
    <p class="text-muted mb-5">
        Sistem ini dirancang khusus untuk menangani kompleksitas penjadwalan akademik dengan mempertimbangkan keterbatasan dosen, ruangan, dan waktu secara dinamis, sehingga menghasilkan efisiensi maksimal bagi institusi pendidikan.
    </p>

    <div class="row g-4 mb-5">
        <div class="col-6">
            <div class="p-4 rounded-4 border bg-light h-100 text-center">
                <div class="h3 text-primary mb-3"><i class="bi bi-lightning-charge"></i></div>
                <h6 class="fw-bold">Optimasi Kombinatorial</h6>
                <p class="small text-muted mb-0">Memecahkan masalah NP-Hard di mana ribuan kombinasi diuji secara paralel untuk hasil terbaik.</p>
            </div>
        </div>
        <div class="col-6">
            <div class="p-4 rounded-4 border bg-light h-100 text-center">
                <div class="h3 text-success mb-3"><i class="bi bi-shield-check"></i></div>
                <h6 class="fw-bold">Zero Tolerance Policy</h6>
                <p class="small text-muted mb-0">Sistem hanya menyimpan hasil jika jadwal terbukti 100% bebas bentrok (Fitness 1.0).</p>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-dark mb-3">💡 Mengapa Algoritma Genetika?</h4>
    <p class="text-muted mb-4">
        Masalah penjadwalan adalah masalah <i>NP-Hard</i> di mana mencoba semua kombinasi secara manual sangatlah mustahil saat data semakin besar. Algoritma Genetika mampu melakukan pencarian ruang solusi secara efisien, memastikan ketersediaan sumber daya kampus digunakan secara optimal.
    </p>
    
    <div class="alert alert-info border-0 rounded-4 p-4 mb-5">
        <div class="d-flex">
            <i class="bi bi-globe me-3 fs-4"></i>
            <div>
                <h6 class="fw-bold">Akses Demo Publik</h6>
                <p class="small mb-0 opacity-75">Anda dapat mencoba versi live sistem ini melalui tautan berikut: <a href="https://algoritmagenetik.up.railway.app/" target="_blank" class="text-primary fw-bold text-decoration-none">Demo Link</a></p>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-dark mb-3">Fitur Utama</h4>
    <ul class="text-muted mb-0">
        <li class="mb-2"><strong>Smart Initialization:</strong> Menjamin tipe ruangan selalu cocok dengan tipe mata kuliah sejak awal.</li>
        <li class="mb-2"><strong>Dynamic Configuration:</strong> Mendukung pengaturan jam operasional dan waktu terlarang (Blackout).</li>
        <li class="mb-2"><strong>Adaptive Evolution:</strong> Laju mutasi yang berubah secara otomatis jika proses evolusi stagnan.</li>
    </ul>
</div>
@endsection
