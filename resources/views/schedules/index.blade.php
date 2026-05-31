@extends('layouts.app')
@section('title', 'Beranda Penjadwalan')

@section('content')
<div class="text-center mb-5 position-relative">
    <div class="ga-visual-container mb-4">
        <div class="ai-evolution-core">
            <div class="orb-glow"></div>
            <div class="orb-morph">
                <i class="bi bi-cpu"></i>
            </div>
            <div class="orbit-ring">
                <div class="satellite s1"></div>
                <div class="satellite s2"></div>
                <div class="satellite s3"></div>
            </div>
        </div>
    </div>
    <h2 class="fw-bold text-dark mb-1">Sistem Penjadwalan Otomatis</h2>
    <p class="text-muted">Optimasi jadwal perkuliahan menggunakan Kecerdasan Buatan (Algoritma Genetika)</p>
</div>

<style>
    .ga-visual-container {
        height: 140px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .ai-evolution-core {
        position: relative;
        width: 100px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .orb-morph {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 1.8rem;
        z-index: 2;
        animation: morphing 8s infinite ease-in-out;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    .orb-glow {
        position: absolute;
        width: 80px;
        height: 80px;
        background: rgba(13, 110, 253, 0.15);
        border-radius: 50%;
        filter: blur(20px);
        animation: pulse-glow 3s infinite ease-in-out;
    }

    .orbit-ring {
        position: absolute;
        width: 110px;
        height: 110px;
        border: 1px solid rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        animation: rotate 15s linear infinite;
    }

    .satellite {
        position: absolute;
        width: 8px;
        height: 8px;
        background: #0dcaf0;
        border-radius: 50%;
        box-shadow: 0 0 10px #0dcaf0;
    }

    .s1 { top: 0; left: 50%; transform: translateX(-50%); }
    .s2 { bottom: 20%; right: 5%; }
    .s3 { bottom: 20%; left: 5%; }

    @keyframes morphing {
        0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        25% { border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%; }
        50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
        75% { border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%; }
        100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    }

    @keyframes pulse-glow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.3); opacity: 0.8; }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('lecturers.index') }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 text-center py-4 transition-all hover-shadow-lg">
                <div class="card-body">
                    <div class="display-5 mb-3 text-primary"><i class="bi bi-person-video3"></i></div>
                    <h5 class="fw-bold mb-1">Dosen</h5>
                    <p class="small text-muted mb-0">Kelola data pengajar</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('buildings.index') }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 text-center py-4 transition-all hover-shadow-lg">
                <div class="card-body">
                    <div class="display-5 mb-3 text-info"><i class="bi bi-building"></i></div>
                    <h5 class="fw-bold mb-1">Gedung</h5>
                    <p class="small text-muted mb-0">Daftar gedung kampus</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('rooms.index') }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 text-center py-4 transition-all hover-shadow-lg">
                <div class="card-body">
                    <div class="display-5 mb-3 text-success"><i class="bi bi-door-open"></i></div>
                    <h5 class="fw-bold mb-1">Ruangan</h5>
                    <p class="small text-muted mb-0">Ruang perkuliahan</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="{{ route('courses.index') }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm border-0 text-center py-4 transition-all hover-shadow-lg">
                <div class="card-body">
                    <div class="display-5 mb-3 text-warning"><i class="bi bi-journal-bookmark"></i></div>
                    <h5 class="fw-bold mb-1">Mata Kuliah</h5>
                    <p class="small text-muted mb-0">Kurikulum & SKS</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-12 p-5 bg-light d-flex flex-column justify-content-center border-bottom">
                        <div class="text-center">
                            <div class="h3 mb-3 text-secondary"><i class="bi bi-gear-wide-connected"></i></div>
                            <h5 class="fw-bold mb-2">Konfigurasi</h5>
                            <p class="small text-muted mb-4">Atur parameter algoritma dan jam operasional.</p>
                            <a href="{{ route('settings.index') }}" class="btn btn-dark w-100 rounded-pill max-w-xs mx-auto" style="max-width: 250px;">Pengaturan</a>
                        </div>
                    </div>
                    <div class="col-12 p-5 bg-white d-flex flex-column justify-content-center text-center">
                        <h4 class="fw-bold mb-3">Generasi Jadwal</h4>
                        <p class="text-muted mb-4 px-md-5">Pastikan seluruh data dosen, ruangan, dan mata kuliah telah diinput dengan benar sebelum menjalankan algoritma.</p>
                        <div class="d-flex justify-content-center">
                            <form action="{{ route('schedules.generate') }}" method="POST" id="generateForm">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg transition-all hover-translate-y">
                                    <i class="bi bi-cpu me-2"></i> Jalankan Algoritma Genetika
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="scheduleResultsContainer">
<div id="scheduleResults" class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-primary">Hasil Penjadwalan Terakhir</h5>
        <div class="d-flex align-items-center gap-3">
            @if(count($schedules) > 0)
                <form action="{{ route('schedules.clear') }}" method="POST" id="resetForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        <i class="bi bi-trash3 me-1"></i> Reset Jadwal
                    </button>
                </form>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 border border-success-subtle">Selesai di-generate</span>
            @endif
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start">Hari</th>
                        <th class="border-0">Waktu</th>
                        <th class="border-0">Mata Kuliah</th>
                        <th class="border-0">Dosen</th>
                        <th class="border-0 rounded-end text-center">Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
                        $dayColors = [
                            'Senin' => 'rgba(13, 110, 253, 0.05)',  // Blue
                            'Selasa' => 'rgba(25, 135, 84, 0.05)',  // Green
                            'Rabu' => 'rgba(255, 193, 7, 0.05)',    // Yellow
                            'Kamis' => 'rgba(13, 202, 240, 0.05)',  // Cyan
                            'Jumat' => 'rgba(220, 53, 69, 0.05)',   // Red
                            'Sabtu' => 'rgba(102, 16, 242, 0.05)',  // Indigo
                            'Minggu' => 'rgba(108, 117, 125, 0.05)' // Gray
                        ];
                        $dayBadgeColors = [
                            'Senin' => 'primary',
                            'Selasa' => 'success',
                            'Rabu' => 'warning',
                            'Kamis' => 'info',
                            'Jumat' => 'danger',
                            'Sabtu' => 'indigo',
                            'Minggu' => 'secondary'
                        ];
                    @endphp
                    @forelse($schedules as $s)
                        @php
                            $dayName = $s->day?->name ?? 'Unknown';
                            $rowColor = $dayColors[$dayName] ?? 'transparent';
                            $badgeColor = $dayBadgeColors[$dayName] ?? 'dark';
                        @endphp
                        <tr style="background-color: {{ $rowColor }}">
                            <td>
                                <span class="badge bg-{{ $badgeColor }} rounded-pill px-3 py-2" style="{{ $badgeColor == 'indigo' ? 'background-color: #6610f2 !important;' : '' }}">
                                    {{ $dayName }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $startTimeStr = $s->startTimeSlot?->start_time ?? '00:00';
                                    $startTime = \Carbon\Carbon::parse($startTimeStr);
                                    $sks = $s->courseOffering?->sks ?? 0;
                                    $totalMinutes = ($sks * $sksDuration) + (($sks > 0 ? $sks - 1 : 0) * 10);
                                    $endTime = $startTime->copy()->addMinutes($totalMinutes);
                                @endphp
                                <span class="badge bg-dark-subtle text-dark border border-dark-subtle fw-medium">
                                    {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $s->courseOffering?->course?->name ?? 'Mata Kuliah Tidak Ditemukan' }}</div>
                                <div class="small text-muted">{{ $s->courseOffering?->course?->sks ?? 0 }} SKS</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $lecturerName = $s->courseOffering?->lecturer?->name ?? 'Dosen Tidak Ditemukan';
                                    @endphp
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <small>{{ substr($lecturerName, 0, 1) }}</small>
                                    </div>
                                    <span class="small">{{ $lecturerName }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info-emphasis px-3 py-2 border border-info-subtle">
                                    {{ $s->room?->building?->name ?? 'Gedung ?' }} | {{ $s->room?->name ?? 'Ruangan ?' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted opacity-50">
                                    <div class="display-1 mb-3"><i class="bi bi-calendar2-x"></i></div>
                                    <h5 class="fw-bold">Belum Ada Jadwal</h5>
                                    <p class="small mb-0">Gunakan tombol "Jalankan Algoritma" di atas untuk membuat jadwal.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<style>
    .transition-all { transition: all 0.3s ease; }
    .hover-shadow-lg:hover { 
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
</style>
@endsection

@push('scripts')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    function updateResults(message, type = 'success') {
        fetch(window.location.pathname, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const container = doc.getElementById('scheduleResultsContainer');
                
                if (container) {
                    document.getElementById('scheduleResultsContainer').innerHTML = container.innerHTML;
                    attachResetListener();
                }

                if (message) {
                    Swal.fire({
                        icon: type,
                        title: type === 'success' ? 'Berhasil!' : 'Gagal',
                        text: message,
                        confirmButtonColor: '#0d6efd',
                        borderRadius: '1rem'
                    });
                }
            })
            .catch(err => {
                console.error('Fetch Update Error:', err);
                if (message) {
                    Swal.fire({
                        title: 'Jadwal Diperbarui',
                        text: message + ' (Silakan refresh halaman jika tabel belum berubah)',
                        icon: 'info'
                    });
                }
            });
    }

    function attachResetListener() {
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Seluruh hasil penjadwalan saat ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    borderRadius: '1rem'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = this;
                        // const cleaning = document.getElementById('cleaning');
                        // cleaning.style.display = 'flex';

                        fetch(form.getAttribute('action'), {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(async response => {
                            const isJson = response.headers.get('content-type')?.includes('application/json');
                            const data = isJson ? await response.json() : null;

                            if (!response.ok) {
                                throw new Error(data?.message || 'Gagal menghapus data (Status: ' + response.status + ')');
                            }
                            return data;
                        })
                        .then(data => {
                            updateResults(data.message);
                        })
                        .catch(error => {
                            console.error('Reset Error:', error);
                            Swal.fire('Error', error.message || 'Terjadi kesalahan saat membersihkan data.', 'error');
                        })
                        .finally(() => {
                            // cleaning.style.display = 'none';
                        });
                    }
                });
            });
        }
    }

    document.getElementById('generateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const loading = document.getElementById('loading');
        loading.style.display = 'flex';

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            }
        })
        .then(async response => {
            const isJson = response.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await response.json() : null;

            if (!response.ok) {
                if (data && data.message) {
                    throw new Error(data.message);
                } else {
                    throw new Error('Server bermasalah (Status: ' + response.status + '). Coba refresh halaman atau cek koneksi internet.');
                }
            }
            return data;
        })
        .then(data => {
            if (data && data.success) {
                updateResults(data.message);
            }
        })
        .catch(error => {
            console.error('Generate Error Details:', error);
            Swal.fire({
                icon: 'error',
                title: 'Opps!',
                text: error.message || 'Koneksi ke server terputus. Silakan coba beberapa saat lagi.',
                confirmButtonColor: '#0d6efd',
                borderRadius: '1rem'
            });
        })
        .finally(() => {
            loading.style.display = 'none';
        });
    });

    // Initial attach
    attachResetListener();
</script>
@endpush
