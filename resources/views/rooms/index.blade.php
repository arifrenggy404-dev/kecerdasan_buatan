@extends('layouts.app')
@section('title', 'Data Ruangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen Ruangan</h3>
        <p class="text-muted small mb-0">Kelola ruang perkuliahan dan laboratorium</p>
    </div>
    <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm transition-all hover-translate-y">
        <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Tambah Ruangan</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Gedung</label>
                        <select name="building_id" class="form-select bg-light" required>
                            <option value="">-- Pilih Gedung --</option>
                            @foreach($buildings as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Ruangan</label>
                        <input type="text" name="name" class="form-control bg-light" placeholder="Contoh: R.301" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Tipe Ruangan</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeTheory" value="theory" checked>
                                <label class="form-check-label" for="typeTheory">Teori</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeLab" value="lab">
                                <label class="form-check-label" for="typeLab">Laboratorium</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Simpan Ruangan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Daftar Ruangan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 border-0 py-3">Gedung & Ruangan</th>
                                <th class="border-0 py-3 text-center">Tipe</th>
                                <th class="border-0 py-3 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $r)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success-subtle text-success rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">{{ substr($r->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $r->name }}</div>
                                            <div class="small text-muted">{{ $r->building->name ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    @if($r->type == 'lab')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3">Lab</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-3">Teori</span>
                                    @endif
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $r->id }}">Edit</button>
                                        <form action="{{ route('rooms.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                        </form>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $r->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <form action="{{ route('rooms.update', $r->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header border-bottom-0 pt-4 px-4">
                                                        <h5 class="fw-bold mb-0">Edit Ruangan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-medium">Gedung</label>
                                                            <select name="building_id" class="form-select bg-light" required>
                                                                @foreach($buildings as $b)
                                                                    <option value="{{ $b->id }}" {{ $r->building_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-medium">Nama Ruangan</label>
                                                            <input type="text" name="name" class="form-control bg-light" value="{{ $r->name }}" required>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label class="form-label fw-medium">Tipe</label>
                                                            <select name="type" class="form-select bg-light" required>
                                                                <option value="theory" {{ $r->type == 'theory' ? 'selected' : '' }}>Teori</option>
                                                                <option value="lab" {{ $r->type == 'lab' ? 'selected' : '' }}>Laboratorium</option>
                                                            </select>
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
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted opacity-50">
                                        <div class="display-1 mb-2"><i class="bi bi-door-closed"></i></div>
                                        <p class="mb-0">Belum ada data ruangan.</p>
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
</div>

<style>
    .transition-all { transition: all 0.2s ease; }
    .hover-translate-y:hover { transform: translateY(-2px); }
</style>
@endsection
