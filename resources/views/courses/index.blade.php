@extends('layouts.app')
@section('title', 'Data Mata Kuliah')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Kurikulum & Mata Kuliah</h3>
        <p class="text-muted small mb-0">Kelola mata kuliah dan plotting dosen pengampu</p>
    </div>
    <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm transition-all hover-translate-y">
        <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Plotting Mata Kuliah</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-uppercase text-muted">Template Mata Kuliah</label>
                        <select name="course_id" class="form-select bg-light" id="courseSelect">
                            <option value="">-- Buat Mata Kuliah Baru --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" 
                                    data-name="{{ $c->name }}" 
                                    data-code="{{ $c->code }}" 
                                    data-sks="{{ $c->sks }}" 
                                    data-type="{{ $c->type }}"
                                    data-semester="{{ $c->semester }}">
                                    [{{ $c->code }}] {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text small">Pilih jika ingin menambah pengampu pada MK yang sudah ada.</div>
                    </div>

                    <div id="newCourseFields" class="bg-light p-3 rounded-3 mb-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Mata Kuliah</label>
                            <input type="text" name="name" class="form-control" id="course_name" placeholder="Contoh: Algoritma">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Kode MK</label>
                            <input type="text" name="code" class="form-control" id="course_code" placeholder="Contoh: AL01">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">SKS</label>
                                <input type="number" name="sks" class="form-control" id="course_sks" min="1" max="6" value="2" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Jenis</label>
                                <select name="type" class="form-select" id="course_type" required>
                                    <option value="theory">Teori</option>
                                    <option value="lab">Praktikum</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-medium">Semester</label>
                            <select name="semester" class="form-select" id="course_semester">
                                <option value="">-- Pilih Semester --</option>
                                <option value="2">Semester 2</option>
                                <option value="4">Semester 4</option>
                                <option value="6">Semester 6</option>
                                <option value="8">Semester 8</option>
                            </select>
                            <div class="form-text small text-primary" id="autoSemesterAlert" style="display:none;">
                                <i class="bi bi-magic me-1"></i> Terdeteksi otomatis dari kode.
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium small text-uppercase text-muted">Penugasan Dosen</label>
                        <select name="lecturer_id" class="form-select bg-primary-subtle border-primary-subtle" required>
                            <option value="">-- Pilih Dosen Pengampu --</option>
                            @foreach($lecturers as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm mt-2">Simpan Plotting</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Daftar Mata Kuliah & Pengampu</h5>
            </div>
            <div class="card-body p-4">
                @php
                    $groupedCourses = $courses->groupBy('semester')->sortKeys();
                @endphp

                @forelse($groupedCourses as $semester => $semesterCourses)
                    <h6 class="fw-bold text-primary mb-3 mt-{{ $loop->first ? '0' : '4' }} d-flex align-items-center">
                        <span class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 0.75rem;">
                            {{ $semester ?: '?' }}
                        </span>
                        Semester {{ $semester ?: 'Lainnya / Tidak Ditentukan' }}
                    </h6>
                    <div class="table-responsive border rounded-3 mb-2">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-3 border-0 py-2" style="width: 100px;">Kode</th>
                                    <th class="border-0 py-2">Mata Kuliah</th>
                                    <th class="border-0 py-2">Pengampu & SKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesterCourses as $c)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <span class="badge bg-light text-dark border px-2 py-1">{{ $c->code }}</span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex justify-content-between align-items-center me-3">
                                            <div class="fw-bold text-dark">{{ $c->name }}</div>
                                            <button class="btn btn-sm btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $c->id }}">
                                                <small><i class="bi bi-pencil-square me-1"></i> Edit MK</small>
                                            </button>
                                        </div>

                                        <!-- Edit Course Modal -->
                                        <div class="modal fade" id="editCourseModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <form action="{{ route('courses.update', $c->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header border-bottom-0 pt-4 px-4">
                                                            <h5 class="fw-bold mb-0">Edit Mata Kuliah</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-medium">Nama Mata Kuliah</label>
                                                                <input type="text" name="name" class="form-control bg-light" value="{{ $c->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-medium">Kode MK</label>
                                                                <input type="text" name="code" class="form-control bg-light" value="{{ $c->code }}">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label fw-medium">SKS Default</label>
                                                                    <input type="number" name="sks" class="form-control bg-light" value="{{ $c->sks }}" min="1" max="6" required>
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label fw-medium">Jenis Default</label>
                                                                    <select name="type" class="form-select bg-light" required>
                                                                        <option value="theory" {{ $c->type == 'theory' ? 'selected' : '' }}>Teori</option>
                                                                        <option value="lab" {{ $c->type == 'lab' ? 'selected' : '' }}>Praktikum</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label fw-medium">Semester</label>
                                                                    <select name="semester" class="form-select bg-light">
                                                                        <option value="">-- Pilih --</option>
                                                                        <option value="2" {{ $c->semester == 2 ? 'selected' : '' }}>Sem 2</option>
                                                                        <option value="4" {{ $c->semester == 4 ? 'selected' : '' }}>Sem 4</option>
                                                                        <option value="6" {{ $c->semester == 6 ? 'selected' : '' }}>Sem 6</option>
                                                                        <option value="8" {{ $c->semester == 8 ? 'selected' : '' }}>Sem 8</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 pb-4 px-4 d-flex justify-content-between">
                                                            <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="if(confirm('Hapus MK ini beserta seluruh plottingnya?')) document.getElementById('deleteCourse{{ $c->id }}').submit()">Hapus MK</button>
                                                            <div>
                                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <form id="deleteCourse{{ $c->id }}" action="{{ route('courses.destroy', $c->id) }}" method="POST" style="display:none;">
                                                        @csrf @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach($c->offerings as $o)
                                                <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center border-0 py-2 ps-0 pe-3">
                                                    <div>
                                                        <div class="small fw-bold">{{ $o->lecturer?->name ?? 'Dosen Tidak Ditemukan' }}</div>
                                                        <div class="d-flex gap-1 mt-1">
                                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill" style="font-size: 0.6rem;">{{ $o->sks }} SKS</span>
                                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill" style="font-size: 0.6rem;">{{ ucfirst($o->type) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm btn-light border rounded-circle p-0" style="width: 24px; height: 24px;" data-bs-toggle="modal" data-bs-target="#editOfferingModal{{ $o->id }}" title="Edit Plotting"><i class="bi bi-pencil-fill" style="font-size: 0.65rem;"></i></button>
                                                        <form action="{{ route('course-offerings.destroy', $o->id) }}" method="POST" onsubmit="return confirm('Hapus plotting ini?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-light border text-danger rounded-circle p-0" style="width: 24px; height: 24px;" title="Hapus Plotting"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
                                                        </form>
                                                    </div>

                                                    <!-- Edit Offering Modal -->
                                                    <div class="modal fade" id="editOfferingModal{{ $o->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                                <form action="{{ route('course-offerings.update', $o->id) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <div class="modal-header border-bottom-0 pt-4 px-4">
                                                                        <h5 class="fw-bold mb-0">Edit Plotting Mata Kuliah</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4 text-start">
                                                                        <div class="p-3 bg-light rounded-3 mb-3">
                                                                            <small class="text-muted text-uppercase fw-bold">Mata Kuliah</small>
                                                                            <div class="fw-bold text-primary">{{ $c->name }}</div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-medium">Dosen Pengampu</label>
                                                                            <select name="lecturer_id" class="form-select" required>
                                                                                @foreach($lecturers as $l)
                                                                                    <option value="{{ $l->id }}" {{ $o->lecturer_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-0">
                                                                                <label class="form-label fw-medium">SKS</label>
                                                                                <input type="number" name="sks" class="form-control" value="{{ $o->sks }}" min="1" max="6" required>
                                                                            </div>
                                                                            <div class="col-md-6 mb-0">
                                                                                <label class="form-label fw-medium">Jenis</label>
                                                                                <select name="type" class="form-select" required>
                                                                                    <option value="theory" {{ $o->type == 'theory' ? 'selected' : '' }}>Teori</option>
                                                                                    <option value="lab" {{ $o->type == 'lab' ? 'selected' : '' }}>Praktikum</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-top-0 pb-4 px-4">
                                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="text-muted opacity-50">
                            <div class="display-1 mb-2"><i class="bi bi-journal-x"></i></div>
                            <p class="mb-0">Belum ada data mata kuliah.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .transition-all { transition: all 0.2s ease; }
    .hover-translate-y:hover { transform: translateY(-2px); }
</style>
@endsection

@push('scripts')
<script>
    const courseSelect = document.getElementById('courseSelect');
    const fields = ['name', 'code'];
    const fieldContainer = document.getElementById('newCourseFields');

    courseSelect.addEventListener('change', function() {
        if (this.value) {
            const selected = this.options[this.selectedIndex];
            fieldContainer.classList.add('bg-primary-subtle');
            fields.forEach(f => {
                const el = document.getElementById('course_' + f);
                el.value = selected.getAttribute('data-' + f);
                el.readOnly = true;
            });
            document.getElementById('course_sks').value = selected.getAttribute('data-sks');
            document.getElementById('course_type').value = selected.getAttribute('data-type');
            document.getElementById('course_semester').value = selected.getAttribute('data-semester');
            document.getElementById('autoSemesterAlert').style.display = 'none';
        } else {
            fieldContainer.classList.remove('bg-primary-subtle');
            fields.forEach(f => {
                const el = document.getElementById('course_' + f);
                el.value = '';
                el.readOnly = false;
            });
            document.getElementById('course_sks').value = 2;
            document.getElementById('course_semester').value = '';
        }
    });

    const codeInput = document.getElementById('course_code');
    const semesterSelect = document.getElementById('course_semester');
    const autoAlert = document.getElementById('autoSemesterAlert');

    codeInput.addEventListener('input', function() {
        if (courseSelect.value) return; // Don't auto-detect if using template

        const code = this.value;
        // Regex to find the first digit after letters
        // Matches digits after a sequence of letters and optional punctuation
        const match = code.match(/[A-Za-z]+.*?\s*([1-3])/);
        
        if (match && match[1]) {
            const digit = match[1];
            let semester = '';
            
            if (digit === '1') semester = '2';
            else if (digit === '2') semester = '4';
            else if (digit === '3') semester = '6';

            if (semester) {
                semesterSelect.value = semester;
                autoAlert.style.display = 'block';
            } else {
                autoAlert.style.display = 'none';
            }
        } else {
            autoAlert.style.display = 'none';
        }
    });
</script>
@endpush
