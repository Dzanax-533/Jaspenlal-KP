@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold text-primary mb-0"><i class="fas fa-box-open me-2"></i> Manajemen Paket Harga</h5>
            <p class="text-muted small mb-0">Atur harga dasar sertifikasi berdasarkan skala usaha klien.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @foreach($pakets as $p)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge rounded-pill bg-primary-soft text-primary px-3 border border-primary">
                            {{ $p->nama_paket }}
                        </span>
                        <button class="btn btn-sm btn-light rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditPaket{{ $p->id }}">
                            <i class="fas fa-edit text-primary"></i>
                        </button>
                    </div>
                    <h3 class="fw-bold mb-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</h3>
                    <p class="text-muted small mb-3 text-truncate-2">{{ $p->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    <hr class="opacity-10">

                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Maksimal 50 Menu</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 1 Fasilitas/Outlet</li>
                        <li><i class="fas fa-info-circle text-info me-2"></i> Biaya dasar sertifikasi</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditPaket{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('admin.paket.update', $p->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                    @csrf @method('PUT')
                    <div class="modal-header border-0 bg-light px-4">
                        <h6 class="modal-title fw-bold">Edit {{ $p->nama_paket }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1">Nama Paket</label>
                                <input type="text" name="nama_paket" value="{{ $p->nama_paket }}" class="form-control rounded-3" required>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1">Harga Dasar (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number" name="harga" value="{{ (int)$p->harga }}" class="form-control rounded-end-3" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1">Deskripsi Paket</label>
                                <textarea name="deskripsi" class="form-control rounded-3" rows="3">{{ $p->deskripsi }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">Simpan Perubahan Harga</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-5">
        <div class="alert alert-info border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex gap-3">
                <i class="fas fa-calculator fa-2x mt-1"></i>
                <div>
                    <h6 class="fw-bold">Informasi Perhitungan Biaya</h6>
                    <p class="small mb-0 opacity-75">
                        Biaya dasar di atas akan ditambah otomatis oleh sistem jika klien memiliki lebih dari 50 menu atau lebih dari 1 outlet sesuai dengan logika yang ada pada <strong>PendaftaranService</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
