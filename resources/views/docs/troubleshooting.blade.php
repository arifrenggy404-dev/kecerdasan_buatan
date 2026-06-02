@extends('layouts.docs')
@section('title', 'Troubleshooting')

@section('content')
<div class="doc-card">
    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 mb-3">Pusat Bantuan</span>
    <h1 class="display-6 fw-bold text-dark mb-4">Penyelesaian Masalah</h1>
    
    <p class="text-muted mb-5">
        Jika sistem mengalami kendala atau gagal menghasilkan jadwal, gunakan panduan berikut untuk mendiagnosis penyebabnya.
    </p>

    <div class="accordion border-0" id="troubleAccordion">
        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Sistem "Loading" Sangat Lama / Stuck
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#troubleAccordion">
                <div class="accordion-body text-muted small">
                    <p><b>Penyebab:</b> Algoritma gagal mencapai fitness 1.0 (Zero Conflict) karena batasan yang terlalu ketat atau kekurangan sumber daya.</p>
                    <p><b>Solusi:</b></p>
                    <ul>
                        <li>Periksa jumlah ruangan. Jika Anda punya 10 kelas di semester yang sama, namun hanya punya 2 ruangan, sistem tidak akan pernah menemukan solusi.</li>
                        <li>Periksa jam operasional. Apakah waktu yang tersedia cukup untuk menampung total SKS semua mata kuliah?</li>
                        <li>Kurangi mata kuliah yang diplot pada dosen yang sama secara berlebihan.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    Tombol "Jalankan" Tidak Merespon
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#troubleAccordion">
                <div class="accordion-body text-muted small">
                    <p><b>Penyebab:</b> Koneksi database terputus atau terdapat data master yang tidak lengkap (misal: mata kuliah tanpa SKS).</p>
                    <p><b>Solusi:</b> Pastikan seluruh data master telah terisi. Periksa log aplikasi di folder <code>storage/logs</code> jika masalah berlanjut.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item border-0 mb-3 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    Hasil Jadwal Terlihat Aneh / Tidak Sesuai
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#troubleAccordion">
                <div class="accordion-body text-muted small">
                    <p><b>Penyebab:</b> Data "TimeSlot" lama mungkin masih tersisa di database.</p>
                    <p><b>Solusi:</b> Sistem secara otomatis membersihkan slot lama setiap kali dijalankan. Namun, jika terjadi kesalahan, klik tombol <b>"Reset"</b> di beranda untuk membersihkan seluruh data jadwal dan memulai ulang.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
