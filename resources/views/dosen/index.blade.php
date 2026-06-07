@extends('layouts.app')
@section('title', 'Data Dosen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen Dosen</h3>
        <p class="text-muted small mb-0">Kelola data pengajar yang akan dijadwalkan</p>
    </div>
    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm transition-all hover-translate-y">
        <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Tambah Dosen</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('dosen.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-medium">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" name="nama" class="form-control border-start-0 bg-light" placeholder="Contoh: Dr. Budi Santoso" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Simpan Dosen</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Daftar Dosen</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 border-0 py-3">Informasi Dosen</th>
                                <th class="border-0 py-3 text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosen as $d)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <span class="fw-bold">{{ substr($d->nama, 0, 1) }}</span>
                                        </div>
                                        <div class="fw-bold text-dark">{{ $d->nama }}</div>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $d->id }}">Edit</button>
                                        <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus dosen ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hapus</button>
                                        </form>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <form action="{{ route('dosen.update', $d->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header border-bottom-0 pt-4 px-4">
                                                        <h5 class="fw-bold mb-0">Edit Informasi Dosen</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <div class="mb-0">
                                                            <label class="form-label fw-medium">Nama Lengkap</label>
                                                            <input type="text" name="nama" class="form-control bg-light" value="{{ $d->nama }}" required>
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
                                        <div class="display-1 mb-2"><i class="bi bi-person-slash"></i></div>
                                        <p class="mb-0">Belum ada data dosen.</p>
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
