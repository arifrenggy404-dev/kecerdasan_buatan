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
    <p class="text-muted small">Optimasi jadwal perkuliahan menggunakan Kecerdasan Buatan (Algoritma Genetika)</p>
</div>

<!-- Simple Integrated Dashboard Navigation & Stats -->
<div class="row g-4 mb-5">
    <div class="col-3">
        <a href="{{ route('lecturers.index') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm border rounded-4 dashboard-card-simple">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-light text-primary">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-arrow-up-right text-muted small"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Data Dosen</h6>
                    <div class="d-flex align-items-baseline">
                        <span class="h3 fw-bold text-dark mb-0">{{ $lecturersCount }}</span>
                        <span class="ms-2 text-muted small">Pengajar</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{ route('buildings.index') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm border rounded-4 dashboard-card-simple">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-light text-info">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-arrow-up-right text-muted small"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Data Gedung</h6>
                    <div class="d-flex align-items-baseline">
                        <span class="h3 fw-bold text-dark mb-0">{{ $buildingsCount }}</span>
                        <span class="ms-2 text-muted small">Gedung</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{ route('rooms.index') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm border rounded-4 dashboard-card-simple">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-light text-success">
                            <i class="bi bi-door-open"></i>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-arrow-up-right text-muted small"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Data Ruangan</h6>
                    <div class="d-flex align-items-baseline">
                        <span class="h3 fw-bold text-dark mb-0">{{ $roomsCount }}</span>
                        <span class="ms-2 text-muted small">Ruangan</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-3">
        <a href="{{ route('courses.index') }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm border rounded-4 dashboard-card-simple">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-light text-warning">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-arrow-up-right text-muted small"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Mata Kuliah</h6>
                    <div class="d-flex align-items-baseline flex-wrap">
                        <span class="h3 fw-bold text-dark mb-0">{{ $coursesCount }}</span>
                        <span class="ms-1 text-muted small me-2">Matkul</span>
                        <span class="badge bg-light text-dark border fw-normal">{{ $offeringsCount }} Kelas</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Konfigurasi Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white border-top border-5 border-dark">
            <div class="card-body p-4 text-center">
                <div class="mx-auto" style="max-width: 600px;">
                    <div class="icon-circle bg-light text-dark shadow-sm mx-auto mb-3" style="width: 50px; height: 50px;">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Konfigurasi Sistem</h5>
                    <p class="text-muted small mb-4">Parameter algoritma, batasan waktu, dan durasi SKS.</p>
                    <a href="{{ route('settings.index') }}" class="btn btn-outline-dark rounded-pill px-5 shadow-sm transition-all hover-translate-y">
                        <i class="bi bi-sliders me-2"></i> Buka Pengaturan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generasi Jadwal Card -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border shadow-sm rounded-4 overflow-hidden border-primary-subtle">
            <div class="card-body p-5 text-center bg-white">
                <div class="mx-auto" style="max-width: 800px;">
                    <h3 class="fw-bold mb-3 text-dark">Generasi Jadwal Otomatis</h3>
                    <p class="text-muted mb-5 px-lg-5">
                        Pastikan seluruh data master (Dosen, Ruangan, Gedung, dan Mata Kuliah) telah diinput dengan benar. 
                        Sistem akan menjalankan Algoritma Genetika untuk menghasilkan jadwal yang optimal dan bebas bentrok.
                    </p>
                    
                    <form action="{{ route('schedules.generate') }}" method="POST" id="generateForm" class="m-0 mx-auto" style="max-width: 450px;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-lg transition-all hover-translate-y d-flex align-items-center justify-content-center fw-bold py-3">
                            <i class="bi bi-cpu me-2 fs-4"></i> JALANKAN PENJADWALAN SEKARANG
                        </button>
                    </form>
                    <div class="mt-4 text-muted small">
                        <i class="bi bi-info-circle me-1"></i> Proses ini mungkin memakan waktu beberapa detik.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="scheduleResultsContainer">
<div id="scheduleResults" class="card border shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <h6 class="fw-bold mb-0 text-dark">Hasil Penjadwalan Terakhir</h6>
        <div class="d-flex align-items-center gap-2">
            @if(count($schedules) > 0)
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="bi bi-download me-1"></i> Ekspor
                </button>
                <form action="{{ route('schedules.clear') }}" method="POST" id="resetForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">
                        <i class="bi bi-trash3 me-1"></i> Reset
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="card-body p-4">
        @php
            $groupedSchedules = $schedules->groupBy(function($s) {
                return $s->courseOffering?->course?->semester ?? 'Lainnya';
            })->sortKeys();
        @endphp

        @forelse($groupedSchedules as $semester => $semesterSchedules)
            <h6 class="fw-bold text-primary mb-3 mt-{{ $loop->first ? '0' : '5' }} d-flex align-items-center">
                <span class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 28px; height: 24px; font-size: 0.8rem;">
                    {{ $semester }}
                </span>
                Semester {{ $semester }}
            </h6>
            
            <div class="table-responsive border rounded-3 mb-2 shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 small text-muted text-uppercase fw-bold">Hari</th>
                            <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Waktu</th>
                            <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Mata Kuliah</th>
                            <th class="border-0 py-3 small text-muted text-uppercase fw-bold">Dosen</th>
                            <th class="border-0 px-4 py-3 small text-muted text-uppercase fw-bold text-center">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @php
                            $sksDuration = \App\Models\Setting::getValue('sks_duration', 50);
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
                        @foreach($semesterSchedules as $s)
                            @php
                                $dayName = $s->day?->name ?? 'Unknown';
                                $badgeColor = $dayBadgeColors[$dayName] ?? 'dark';
                            @endphp
                            <tr>
                                <td class="px-4">
                                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} border border-{{ $badgeColor }}-subtle rounded-pill px-3 py-1">
                                        {{ $dayName }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $startTimeStr = $s->startTimeSlot?->start_time ?? '00:00';
                                        $startTime = \Carbon\Carbon::parse($startTimeStr);
                                        $sks = $s->courseOffering?->sks ?? 0;
                                        $totalMinutes = $sks * $sksDuration;
                                        $endTime = $startTime->copy()->addMinutes($totalMinutes);
                                    @endphp
                                    <span class="small text-dark fw-medium">
                                        {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold small">{{ $s->courseOffering?->course?->name ?? '-' }}</div>
                                    <div class="x-small text-muted" style="font-size: 0.7rem;">{{ $sks }} SKS</div>
                                </td>
                                <td>
                                    <div class="small">{{ $s->courseOffering?->lecturer?->name ?? '-' }}</div>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="badge bg-light text-dark border px-3 py-1 fw-medium" style="font-size: 0.75rem;">
                                        {{ $s->room?->name ?? '?' }}
                                    </div>
                                    <div class="x-small text-muted mt-1" style="font-size: 0.65rem;">{{ $s->room?->building?->name ?? '-' }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="text-muted opacity-50">
                    <div class="h2 mb-3"><i class="bi bi-calendar-x"></i></div>
                    <p class="small mb-0">Klik tombol "Jalankan Penjadwalan" di atas.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
</div>
</div>

<style>
    .dashboard-card-simple {
        transition: all 0.2s ease-in-out;
        background: white;
    }
    .dashboard-card-simple:hover {
        border-color: #0d6efd !important;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05) !important;
    }
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .bg-light { background-color: #f8f9fa !important; }
    .x-small { font-size: 0.8rem; }
    
    .ga-visual-container {
        height: 180px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .ai-evolution-core { position: relative; width: 140px; height: 140px; display: flex; justify-content: center; align-items: center; }
    .orb-morph { width: 90px; height: 90px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; display: flex; justify-content: center; align-items: center; color: white; font-size: 2.8rem; z-index: 2; animation: morphing 8s infinite ease-in-out; }
    .orb-glow { position: absolute; width: 120px; height: 120px; background: rgba(13, 110, 253, 0.1); border-radius: 50%; filter: blur(25px); animation: pulse-glow 3s infinite ease-in-out; }
    .orbit-ring { position: absolute; width: 160px; height: 160px; border: 1px solid rgba(13, 110, 253, 0.1); border-radius: 50%; animation: rotate 15s linear infinite; }
    .satellite { position: absolute; width: 10px; height: 10px; background: #0dcaf0; border-radius: 50%; }
    .s1 { top: 0; left: 50%; transform: translateX(-50%); }
    .s2 { bottom: 20%; right: 5%; }
    .s3 { bottom: 20%; left: 5%; }

    @keyframes morphing {
        0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        50% { border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%; }
    }
    @keyframes pulse-glow { 0%, 100% { transform: scale(1); opacity: 0.4; } 50% { transform: scale(1.2); opacity: 0.6; } }
    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .transition-all { transition: all 0.2s ease; }
    .hover-translate-y:hover { transform: translateY(-2px); }
</style>
@endsection

@push('modals')
<!-- Modal Ekspor -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-bold" id="exportModalLabel">Ekspor Jadwal</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted mb-2 text-uppercase">Nama File</label>
                    <input type="text" id="customFilename" class="form-control bg-light border-0 py-2" placeholder="jadwal_perkuliahan_{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="form-label small fw-bold text-muted mb-2 text-uppercase">Format</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="exportFormat" id="formatCSV" value="csv" checked>
                            <label class="btn btn-outline-success w-100 py-3 rounded-3" for="formatCSV">
                                <i class="bi bi-filetype-csv fs-4 d-block mb-1"></i>
                                <span class="small fw-bold">Excel/CSV</span>
                            </label>
                        </div>
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="exportFormat" id="formatPDF" value="pdf">
                            <label class="btn btn-outline-danger w-100 py-3 rounded-3" for="formatPDF">
                                <i class="bi bi-filetype-pdf fs-4 d-block mb-1"></i>
                                <span class="small fw-bold">PDF</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 p-4">
                <button type="button" id="btnProcessExport" class="btn btn-primary w-100 rounded-pill fw-bold">Ekspor Sekarang</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function initSchedulePage() {
        const generateForm = document.getElementById('generateForm');
        if (generateForm) {
            generateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                document.getElementById('loading').style.display = 'flex';
                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    }
                })
                .then(async res => { 
                    const data = await res.json(); 
                    if (!res.ok) throw new Error(data.message); 
                    return data; 
                })
                .then(data => { 
                    if (data.success) updateResults(data.message); 
                })
                .catch(err => { 
                    Swal.fire({ icon: 'error', title: 'Opps!', text: err.message, confirmButtonColor: '#0d6efd', borderRadius: '1rem' }); 
                })
                .finally(() => { 
                    document.getElementById('loading').style.display = 'none'; 
                });
            });
        }

        const btnProcessExport = document.getElementById('btnProcessExport');
        if (btnProcessExport) {
            btnProcessExport.addEventListener('click', function() {
                const filename = document.getElementById('customFilename').value.trim();
                const format = document.querySelector('input[name="exportFormat"]:checked').value;
                let baseUrl = format === 'csv' ? "{{ route('schedules.export.csv') }}" : "{{ route('schedules.export.pdf') }}";
                let url = new URL(baseUrl, window.location.origin);
                if (filename) url.searchParams.append('filename', filename);
                window.location.href = url.toString();
                
                const exportModal = document.getElementById('exportModal');
                if (exportModal) {
                    const modalInstance = bootstrap.Modal.getInstance(exportModal);
                    if (modalInstance) modalInstance.hide();
                }
            });
        }

        attachResetListener();
    }

    function updateResults(message, type = 'success') {
        fetch(window.location.pathname, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const container = doc.getElementById('scheduleResultsContainer');
                if (container) {
                    document.getElementById('scheduleResultsContainer').innerHTML = container.innerHTML;
                    attachResetListener();
                }
                if (message) Swal.fire({ icon: type, title: type === 'success' ? 'Berhasil' : 'Gagal', text: message, confirmButtonColor: '#0d6efd', borderRadius: '1rem' });
            });
    }

    function attachResetListener() {
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({ title: 'Hapus?', text: "Data akan dihapus permanen.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', borderRadius: '1rem' }).then((result) => {
                    if (result.isConfirmed) {
                        const form = this;
                        fetch(form.getAttribute('action'), { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value } })
                        .then(res => res.json()).then(data => updateResults(data.message));
                    }
                });
            });
        }
    }

    document.addEventListener('turbo:load', initSchedulePage);
</script>
@endpush
