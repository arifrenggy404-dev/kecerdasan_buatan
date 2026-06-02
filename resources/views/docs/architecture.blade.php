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
                <span class="badge bg-dark me-2">Building</span> memiliki banyak <span class="badge bg-primary">Room</span>.
            </li>
            <li class="mb-3">
                <span class="badge bg-dark me-2">Course</span> memiliki banyak <span class="badge bg-success">CourseOffering</span> (Kelas).
            </li>
            <li class="mb-3">
                <span class="badge bg-success me-2">CourseOffering</span> terhubung ke satu <span class="badge bg-warning text-dark">Lecturer</span>.
            </li>
            <li>
                <span class="badge bg-danger me-2">Schedule</span> adalah hasil akhir yang menghubungkan <b>Offering</b>, <b>Room</b>, <b>Day</b>, dan <b>TimeSlot</b>.
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
                    <td class="fw-bold text-dark">courses</td>
                    <td>Data master mata kuliah.</td>
                    <td>name, sks, semester</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">course_offerings</td>
                    <td>Plotting dosen ke mata kuliah.</td>
                    <td>course_id, lecturer_id, type (Teori/Lab)</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">rooms</td>
                    <td>Lokasi fisik perkuliahan.</td>
                    <td>name, building_id, type</td>
                </tr>
                <tr>
                    <td class="fw-bold text-dark">schedules</td>
                    <td>Penyimpanan hasil optimasi AI.</td>
                    <td>batch_id, room_id, timeslot_id, day_id</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h5 class="fw-bold mb-3">Alur Hidup Data (Data Lifecycle)</h5>
    <p class="text-muted small mb-4">
        1. <b>Input:</b> Admin memasukkan data master (Gedung, Ruangan, Dosen, Matkul).<br>
        2. <b>Processing:</b> Saat tombol generate diklik, <code>GeneticAlgorithmService</code> mengambil semua data master dan menyimpannya di memori (RAM) dalam bentuk Array untuk pemrosesan cepat.<br>
        3. <b>Output:</b> Jika solusi ditemukan, data di-*mapping* kembali ke ID database dan disimpan secara massal (bulk insert) ke tabel <code>schedules</code>.
    </p>
</div>
@endsection
