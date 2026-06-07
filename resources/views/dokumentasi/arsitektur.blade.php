@extends('layouts.docs')
@section('title', 'Arsitektur Data')

@section('content')
<div class="doc-card">
    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">Model & Skema</span>
    <h1 class="display-6 fw-bold text-dark mb-4">Arsitektur & Alur Data</h1>
    
    <p class="text-muted mb-5">
        Memahami bagaimana data saling terhubung adalah kunci untuk mengelola sistem penjadwalan ini. Berikut adalah struktur tabel utama dan relasinya.
    </p>

    <h5 class="fw-bold mb-3"><i class="bi bi-diagram-2 me-2"></i>Relasi Entitas (ERD)</h5>
    <div class="p-4 bg-light rounded-4 mb-4 border">
        <ul class="list-unstyled mb-0">
            <li class="mb-3">
                <span class="badge bg-dark me-2">Gedung</span> memiliki banyak <span class="badge bg-primary">Ruangan</span>.
            </li>
            <li class="mb-3">
                <span class="badge bg-dark me-2">Mata Kuliah</span> memiliki banyak <span class="badge bg-success">Kelas</span>.
            </li>
            <li class="mb-3">
                <span class="badge bg-success me-2">Kelas</span> terhubung ke satu <span class="badge bg-warning text-dark">Dosen</span>.
            </li>
            <li>
                <span class="badge bg-danger me-2">Jadwal</span> adalah hasil akhir yang menghubungkan <b>Kelas</b>, <b>Ruangan</b>, <b>Hari</b>, dan <b>Slot Waktu</b>.
            </li>
        </ul>
    </div>

    <h5 class="fw-bold mb-3">Detail Tabel Utama</h5>
    <div class="table-responsive mb-5">
        <table class="table table-hover border">
            <thead class="bg-light small">
                <tr>
                    <th>Tabel</th>
                    <th>Fungsi Utama</th>
                    <th>Kolom Kunci</th>
                </tr>
            </thead>
            <tbody class="small text-muted">
                <tr>
                    <td class="fw-bold text-dark">mata_kuliah</td>
                    <td>Data master mata kuliah.</td>
                    <td>nama, sks, semester</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">kelas</td>
                    <td>Plotting dosen ke mata kuliah.</td>
                    <td>mata_kuliah_id, dosen_id, tipe (Teori/Lab)</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">ruangan</td>
                    <td>Lokasi fisik perkuliahan.</td>
                    <td>nama, gedung_id, tipe</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">jadwal</td>
                    <td>Penyimpanan hasil optimasi AI.</td>
                    <td>id_batch, ruangan_id, slot_waktu_mulai_id, hari_id</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h5 class="fw-bold mb-3">Alur Hidup Data (Data Lifecycle)</h5>
    <p class="text-muted small mb-4">
        1. <b>Input:</b> Admin memasukkan data master (Gedung, Ruangan, Dosen, Mata Kuliah).<br>
        2. <b>Processing:</b> Saat tombol generate diklik, <code>AlgoritmaGenetikaService</code> mengambil semua data master dan menyimpannya di memori (RAM) dalam bentuk Array untuk pemrosesan cepat.<br>
        3. <b>Output:</b> Jika solusi ditemukan, data di-*mapping* kembali ke ID database dan disimpan secara massal (bulk insert) ke tabel <code>jadwal</code>.
    </p>
</div>
@endsection
