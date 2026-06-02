@extends('layouts.docs')
@section('title', 'Algoritma Genetika')

@section('content')
<div class="doc-card">
    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 mb-3">Arsitektur Kecerdasan Buatan</span>
    <h1 class="display-5 fw-bold text-dark mb-4">Anatomi Algoritma Genetika</h1>
    
    <p class="lead text-muted mb-5">
        Dokumentasi teknis mendalam mengenai implementasi <code>GeneticAlgorithmService</code>. Bagian ini membedah setiap fungsi kunci, potongan kode, dan logika matematis di baliknya.
    </p>

    <!-- 1. Konfigurasi Dinamis -->
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">1. Konfigurasi Dinamis (Environment)</h4>
        <p class="text-muted">
            Sebelum algoritma berjalan, sistem menyiapkan lingkungan berdasarkan data dari tabel <code>settings</code>. Hal ini memungkinkan sistem untuk adaptif terhadap kebijakan universitas yang berubah-ubah tanpa harus mengubah kode program.
        </p>
        <ul class="text-muted small mb-4">
            <li class="mb-2"><strong>Operational Hours:</strong> Jam mulai dan berakhir operasional kampus yang membatasi area pencarian slot waktu.</li>
            <li class="mb-2"><strong>Blackout Hours:</strong> Waktu jeda (misal: sholat Jumat atau rapat rutin) di mana perkuliahan tidak boleh dijadwalkan sama sekali.</li>
            <li class="mb-2"><strong>Continuous Time:</strong> Sistem menghitung durasi SKS secara kontinu (misal: 3 SKS = 150 menit) tanpa jeda paksa antar slot untuk akurasi jam selesai.</li>
        </ul>
    </div>

    <!-- 2. Smart Initialization -->
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">2. Inisialisasi Populasi Cerdas</h4>
        <p class="text-muted">
            Berbeda dengan inisialisasi acak biasa, sistem ini menggunakan <strong>Smart Initialization</strong> untuk mempercepat proses konvergensi (pencarian solusi).
        </p>
        <div class="code-block mb-3">
<pre class="mb-0" style="color: #a9b7c6;">
// Memastikan tipe ruangan cocok (Teori vs Lab)
$compatibleRoomIndices = $roomsByType[$offering['type']];
$roomIdx = $compatibleRoomIndices[array_rand($compatibleRoomIndices)];

// Menghindari slot blackout sejak awal pembentukan
for ($retry = 0; $retry < 10; $retry++) {
    if (!$this->isBlackout($dayId, $slotIdx, $sks)) break;
    // ... cari slot lain
}</pre>
        </div>
        <p class="small text-muted border-start ps-3">
            <strong>Analisis Kode:</strong> Dengan menyaring kecocokan ruangan dan menghindari waktu terlarang (Blackout) sejak tahap inisialisasi, sistem menghemat ribuan generasi evolusi karena tidak perlu "belajar" menghindari kesalahan dasar tersebut.
        </p>
    </div>

    <!-- 3. Perhitungan Fitness -->
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">3. Evaluasi Fitness & Penalti</h4>
        <p class="text-muted">
            Fungsi ini adalah "otak" dari sistem. Ia memeriksa setiap pasang jadwal untuk menemukan pelanggaran aturan. Jika terjadi bentrok, nilai <strong>Penalty</strong> akan bertambah drastis.
        </p>
        <div class="code-block mb-3">
<pre class="mb-0" style="color: #a9b7c6;">
if ($isOverlapping) {
    // Bentrok Dosen: Satu dosen di dua tempat
    if ($g1['lecturer_id'] === $g2['lecturer_id']) {
        $penalty += 1000000;
    }
    // Bentrok Ruangan: Satu ruangan untuk dua kelas
    if ($g1['room_id'] === $g2['room_id']) {
        $penalty += 1000000;
    }
}
return ($penalty === 0) ? 1.0 : (1 / (1 + $penalty));</pre>
        </div>
        <p class="small text-muted border-start ps-3">
            <strong>Analisis Kode:</strong> Menggunakan nilai penalti yang sangat besar (1 juta) untuk memastikan jadwal dengan satu bentrok saja sudah dianggap "sangat buruk" oleh sistem. Nilai fitness dihitung dengan rumus inversi: semakin besar penalti, semakin kecil (mendekati 0) nilai fitness-nya.
        </p>
    </div>

    <!-- 3. Tournament Selection -->
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">3. Seleksi Turnamen (Survival of the Fittest)</h4>
        <p class="text-muted">
            Bagaimana sistem memilih calon "orang tua"? Daripada memilih yang terbaik secara kaku, sistem mengambil 5 individu secara acak dan mengadu mereka. Pemenangnya akan menjadi induk untuk generasi berikutnya.
        </p>
        <div class="code-block mb-3">
<pre class="mb-0" style="color: #a9b7c6;">
protected function tournamentSelection(array $scored): array {
    $tournamentSize = 5;
    for ($i = 0; $i < $tournamentSize; $i++) {
        $idx = rand(0, count($scored) - 1);
        $competitor = $scored[$idx];
        if ($best === null || $competitor['f'] > $best['f']) {
            $best = $competitor;
        }
    }
    return $best['c'];
}</pre>
        </div>
        <p class="small text-muted border-start ps-3">
            <strong>Analisis Kode:</strong> Metode Turnamen mencegah dominasi individu terbaik (super-individu) yang dapat menyebabkan keberagaman populasi hilang terlalu cepat. Ini menjaga keseimbangan antara eksploitasi (mencari yang terbaik) dan eksplorasi (mencoba variasi lain).
        </p>
    </div>

    <!-- 4. Crossover & Mutasi -->
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">4. Rekombinasi Genetik (Crossover & Mutasi)</h4>
        <p class="text-muted">
            Setelah orang tua terpilih, sistem melakukan <strong>Crossover</strong> (menukar potongan jadwal) dan <strong>Mutasi</strong> (mengubah satu slot secara acak).
        </p>
        <div class="code-block mb-3">
<pre class="mb-0" style="color: #a9b7c6;">
// Crossover: Menukar gen pada titik acak
$child[$i] = ($i < $cp) ? $p1[$i] : $p2[$i];

// Mutasi: Mengubah slot waktu/ruang secara acak
if ((mt_rand() / mt_getrandmax()) < $this->mutationRate) {
    $gene['day_idx'] = array_rand($this->days);
    $gene['slot_idx'] = rand(0, $maxSlotIdx);
}</pre>
        </div>
        <p class="small text-muted border-start ps-3">
            <strong>Analisis Kode:</strong> Crossover bertugas menggabungkan solusi yang sudah bagus. Mutasi bertugas memberikan "kejutan" baru agar sistem tidak terjebak dalam pola yang sama. Tanpa mutasi, evolusi akan berhenti ketika seluruh populasi sudah seragam.
        </p>
    </div>

    <div class="mt-5 p-4 bg-light rounded-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Kebijakan Konvergensi (Zero Tolerance)</h6>
        <p class="small text-muted mb-0">
            Sistem ini menerapkan kebijakan <strong>Zero Tolerance</strong>. Algoritma hanya akan menyimpan hasil ke database jika ditemukan individu dengan <strong>Fitness = 1.0 (Nol Bentrok)</strong>. Jika hingga generasi maksimal solusi sempurna belum ditemukan, sistem tidak akan menyimpan jadwal apa pun untuk menjamin integritas data akademik dan mencegah jadwal yang cacat digunakan oleh universitas.
        </p>
    </div>
</div>
@endsection
