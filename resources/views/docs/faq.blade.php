@extends('layouts.docs')
@section('title', 'FAQ')

@section('content')
<div class="doc-card">
    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 mb-3">Tanya Jawab</span>
    <h1 class="display-6 fw-bold text-dark mb-4">Frequently Asked Questions</h1>
    
    <p class="text-muted mb-5">
        Berikut adalah kumpulan pertanyaan yang sering diajukan mengenai penggunaan sistem penjadwalan ini.
    </p>

    <div class="mb-5">
        <h6 class="fw-bold text-dark">Berapa lama proses pembuatan jadwal biasanya memakan waktu?</h6>
        <p class="text-muted small">Tergantung pada jumlah data. Untuk 50-100 kelas, biasanya memakan waktu 5-30 detik. Jika data sangat padat dan ruangan sedikit, proses bisa lebih lama karena sistem mencari solusi tanpa bentrok.</p>
    </div>

    <hr class="my-4 opacity-50">

    <div class="mb-5">
        <h6 class="fw-bold text-dark">Mengapa saya tidak bisa menyimpan jadwal yang masih ada bentroknya?</h6>
        <p class="text-muted small">Sistem ini menggunakan kebijakan "Zero Tolerance". Jadwal yang bentrok hanya akan menimbulkan masalah di lapangan (dosen tidak hadir atau ruangan dipakai orang lain). Sistem memaksa pencarian hingga 100% sempurna untuk menjamin kualitas hasil.</p>
    </div>

    <hr class="my-4 opacity-50">

    <div class="mb-5">
        <h6 class="fw-bold text-dark">Apakah saya bisa mengubah hari kerja setelah jadwal dibuat?</h6>
        <p class="text-muted small">Ya, Anda bisa mengubahnya di menu Pengaturan. Namun, jadwal yang sudah ada tidak akan berubah secara otomatis. Anda harus menjalankan proses "Jalankan Penjadwalan" kembali agar sistem menyesuaikan jadwal dengan hari kerja yang baru.</p>
    </div>

    <hr class="my-4 opacity-50">

    <div class="mb-5">
        <h6 class="fw-bold text-dark">Apa arti nilai Fitness 1.0?</h6>
        <p class="text-muted small">Nilai Fitness adalah angka kualitas. Angka 1.0 berarti sistem telah berhasil memposisikan seluruh mata kuliah ke dalam waktu dan tempat yang tepat tanpa melanggar satu pun aturan (Zero Conflict).</p>
    </div>

    <div class="mt-5 text-center">
        <p class="text-muted small mb-0">Pertanyaan belum terjawab? Hubungi tim pengembang sistem.</p>
    </div>
</div>
@endsection
