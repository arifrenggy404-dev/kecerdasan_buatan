@extends('layouts.docs')
@section('title', 'Ekspor & Laporan')

@section('content')
<div class="doc-card">
    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 mb-3">Manajemen Output</span>
    <h1 class="display-6 fw-bold text-dark mb-4">Ekspor & Laporan Jadwal</h1>
    
    <p class="text-muted mb-5">
        Setelah jadwal berhasil dibuat, Anda dapat membagikannya atau menggunakannya di aplikasi lain melalui fitur ekspor.
    </p>

    <div class="row g-4 mb-5">
        <div class="col-6">
            <div class="p-4 border rounded-4">
                <div class="h3 text-success mb-3"><i class="bi bi-file-earmark-excel"></i></div>
                <h6 class="fw-bold">Format Excel/CSV</h6>
                <p class="small text-muted mb-0">Format terbaik jika Anda ingin mengolah data kembali di Excel atau mengimpornya ke sistem informasi universitas lainnya.</p>
            </div>
        </div>
        <div class="col-6">
            <div class="p-4 border rounded-4">
                <div class="h3 text-danger mb-3"><i class="bi bi-file-earmark-pdf"></i></div>
                <h6 class="fw-bold">Format PDF</h6>
                <p class="small text-muted mb-0">Format siap cetak yang rapi untuk dibagikan kepada dosen dan ditempel di papan pengumuman jurusan.</p>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Cara Melakukan Ekspor</h5>
    <ol class="text-muted small mb-5">
        <li class="mb-2">Pastikan jadwal sudah muncul di tabel "Hasil Penjadwalan Terakhir".</li>
        <li class="mb-2">Klik tombol <b>"Ekspor"</b> di bagian kanan atas tabel.</li>
        <li class="mb-2">Masukkan nama file kustom (opsional) pada jendela modal yang muncul.</li>
        <li class="mb-2">Pilih format (CSV atau PDF) lalu klik <b>"Ekspor Sekarang"</b>.</li>
    </ol>

    <div class="p-4 bg-light rounded-4 border-start border-5 border-warning">
        <h6 class="fw-bold mb-2">Tips:</h6>
        <p class="small text-muted mb-0">Gunakan format CSV jika Anda berencana melakukan pengeditan manual pada nama mata kuliah atau dosen sebelum mempublikasikannya secara luas.</p>
    </div>
</div>
@endsection
