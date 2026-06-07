@extends('layouts.app')
@section('title', 'Pengaturan Waktu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Pengaturan Sistem</h3>
        <p class="text-muted small mb-0">Atur parameter waktu dan batasan Algoritma Genetika</p>
    </div>
    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm transition-all hover-translate-y">
        <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="fw-bold mb-0">Konfigurasi Parameter Penjadwalan</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('pengaturan.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-5">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label class="form-label fw-bold text-dark d-block mb-3">
                                    <span class="bg-primary-subtle text-primary rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.8rem;">1</span>
                                    Hari Kerja Aktif
                                </label>
                                <div class="bg-light p-3 rounded-4">
                                    <div class="row g-2">
                                        @foreach($semuaHari as $id => $nama)
                                        <div class="col-6">
                                            <div class="form-check custom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="hari_aktif[]" value="{{ $id }}" 
                                                    id="day_{{ $id }}" {{ in_array($id, $hariAktif) ? 'checked' : '' }}>
                                                <label class="form-check-label small fw-medium" for="day_{{ $id }}">
                                                    {{ $nama }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-bold text-dark d-block mb-3">
                                    <span class="bg-primary-subtle text-primary rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.8rem;">2</span>
                                    Jam Operasional Kuliah
                                </label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="small text-muted mb-1">Mulai</label>
                                        <input type="time" name="jam_operasional_mulai" class="form-control bg-light border-0 py-2 rounded-3" value="{{ $jamOperasional['mulai'] }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="small text-muted mb-1">Selesai</label>
                                        <input type="time" name="jam_operasional_selesai" class="form-control bg-light border-0 py-2 rounded-3" value="{{ $jamOperasional['selesai'] }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-5">
                                <label class="form-label fw-bold text-dark d-block mb-3">
                                    <span class="bg-primary-subtle text-primary rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.8rem;">3</span>
                                    Waktu Istirahat / Khusus (Blackout)
                                </label>
                                <p class="small text-muted mb-3">Jadwal tidak akan ditempatkan pada hari dan jam berikut.</p>
                                
                                <div id="blackout-container">
                                    @forelse($jamIstirahat as $index => $b)
                                    <div class="blackout-item bg-light p-3 rounded-4 mb-3 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-blackout" style="font-size: 0.7rem;"></button>
                                        <div class="row g-2">
                                            <div class="col-12 mb-2">
                                                <label class="small text-muted mb-1">Hari</label>
                                                <select name="jam_istirahat_hari[]" class="form-select border-0 bg-white small">
                                                    <option value="0" {{ ($b['hari_id'] ?? 0) == 0 ? 'selected' : '' }}>Semua Hari</option>
                                                    @foreach($semuaHari as $id => $nama)
                                                    <option value="{{ $id }}" {{ ($b['hari_id'] ?? 0) == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="small text-muted mb-1">Mulai</label>
                                                <input type="time" name="jam_istirahat_mulai[]" class="form-control border-0 bg-white small" value="{{ $b['mulai'] ?? '' }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="small text-muted mb-1">Selesai</label>
                                                <input type="time" name="jam_istirahat_selesai[]" class="form-control border-0 bg-white small" value="{{ $b['selesai'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="blackout-item bg-light p-3 rounded-4 mb-3 position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-blackout" style="font-size: 0.7rem;"></button>
                                        <div class="row g-2">
                                            <div class="col-12 mb-2">
                                                <label class="small text-muted mb-1">Hari</label>
                                                <select name="jam_istirahat_hari[]" class="form-select border-0 bg-white small">
                                                    <option value="0">Semua Hari</option>
                                                    @foreach($semuaHari as $id => $nama)
                                                    <option value="{{ $id }}">{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="small text-muted mb-1">Mulai</label>
                                                <input type="time" name="jam_istirahat_mulai[]" class="form-control border-0 bg-white small">
                                            </div>
                                            <div class="col-6">
                                                <label class="small text-muted mb-1">Selesai</label>
                                                <input type="time" name="jam_istirahat_selesai[]" class="form-control border-0 bg-white small">
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                                
                                <button type="button" id="add-blackout" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    <i class="bi bi-plus-circle me-1"></i> Tambah Waktu Blackout
                                </button>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-bold text-dark d-block mb-3">
                                    <span class="bg-primary-subtle text-primary rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.8rem;">4</span>
                                    Durasi Per SKS
                                </label>
                                <div class="bg-light p-3 rounded-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="input-group" style="max-width: 180px;">
                                            <input type="number" name="durasi_sks" class="form-control border-0 py-2" value="{{ $durasiSks }}" min="10" max="120" required>
                                            <span class="input-group-text border-0 bg-white small text-muted">Menit</span>
                                        </div>
                                        <span class="small text-muted">Contoh standar: 50 menit per SKS.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top text-end">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3 bg-white p-4 rounded-4 shadow-sm mt-4 border border-info-subtle">
            <div class="display-6 text-info"><i class="bi bi-info-circle"></i></div>
            <div>
                <h6 class="fw-bold mb-1">Penting</h6>
                <p class="small text-muted mb-0">Perubahan pada pengaturan ini akan memengaruhi hasil generate jadwal selanjutnya. Algoritma akan mencoba menyesuaikan slot waktu berdasarkan batasan baru yang Anda buat.</p>
            </div>
        </div>
    </div>
</div>

<template id="blackout-template">
    <div class="blackout-item bg-light p-3 rounded-4 mb-3 position-relative">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-blackout" style="font-size: 0.7rem;"></button>
        <div class="row g-2">
            <div class="col-12 mb-2">
                <label class="small text-muted mb-1">Hari</label>
                <select name="jam_istirahat_hari[]" class="form-select border-0 bg-white small">
                    <option value="0">Semua Hari</option>
                    @foreach($semuaHari as $id => $nama)
                    <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="small text-muted mb-1">Mulai</label>
                <input type="time" name="jam_istirahat_mulai[]" class="form-control border-0 bg-white small">
            </div>
            <div class="col-6">
                <label class="small text-muted mb-1">Selesai</label>
                <input type="time" name="jam_istirahat_selesai[]" class="form-control border-0 bg-white small">
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('blackout-container');
    const template = document.getElementById('blackout-template');
    const addButton = document.getElementById('add-blackout');

    addButton.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        container.appendChild(clone);
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-blackout')) {
            e.target.closest('.blackout-item').remove();
        }
    });
});
</script>

<style>
    .transition-all { transition: all 0.2s ease; }
    .hover-translate-y:hover { transform: translateY(-2px); }
    .custom-checkbox .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .blackout-item { border-left: 4px solid #0d6efd; }
</style>
@endsection
