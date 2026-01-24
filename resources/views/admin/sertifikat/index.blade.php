@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-800 text-deep-forest"><i class="fas fa-certificate me-2 text-success"></i> Penerbitan Sertifikat Final</h4>
            <p class="text-muted small">Daftar pendaftaran Level 10 yang telah divalidasi pembayarannya oleh Tim Keuangan.</p>
        </div>
    </div>

    <div class="overflow-hidden border-0 shadow-sm card rounded-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="py-3 ps-4">No. Registrasi</th>
                        <th>Klien / Perusahaan</th>
                        <th class="text-center">Status Sistem</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td class="ps-4">
                            <span class="font-monospace fw-bold text-primary">{{ $row->no_pendaftaran }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $row->user->name }}</div>
                            <div class="x-small text-muted">{{ $row->user->klienDetail->nama_perusahaan ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            @if($row->file_sertifikat)
                                <span class="badge bg-soft-success text-success rounded-pill px-3">
                                    <i class="fas fa-check-circle me-1"></i> Sertifikat Terbit
                                </span>
                            @else
                                <span class="badge bg-soft-warning text-warning rounded-pill px-3">
                                    <i class="fas fa-clock me-1"></i> Siap Terbit
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($row->file_sertifikat)
                                <div class="btn-group">
                                    <a href="{{ asset('storage/' . $row->file_sertifikat) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                    <button class="btn btn-sm btn-light border rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTerbit{{ $row->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            @else
                                <button class="px-3 shadow-sm btn btn-sm btn-success rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalTerbit{{ $row->id }}">
                                    <i class="fas fa-upload me-1"></i> Upload Sertifikat
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-5 text-center text-muted">
                            <i class="mb-3 opacity-25 fas fa-file-contract fa-3x"></i>
                            <p class="mb-0">Tidak ada antrean penerbitan sertifikat saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD --}}
@foreach($data as $row)
<div class="modal fade" id="modalTerbit{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            {{-- PERBAIKAN: Route diarahkan ke admin.operasional.sertifikat.upload --}}
            <form action="{{ route('admin.operasional.sertifikat.upload', $row->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 pt-4 border-0 modal-header">
                    <h6 class="mb-0 fw-bold">Penerbitan Sertifikat Final</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-4 text-center modal-body">
                    <div class="p-3 mb-3 bg-soft-success rounded-circle d-inline-block">
                        <i class="fas fa-file-signature fa-3x text-success"></i>
                    </div>
                    <h6 class="mb-1 fw-bold text-dark">{{ $row->no_pendaftaran }}</h6>
                    <p class="mb-4 small text-muted">Silakan unggah dokumen Sertifikat Halal resmi (PDF) untuk <strong>{{ $row->user->name }}</strong>.</p>

                    <div class="mb-3 text-start">
                        <label class="mb-2 small fw-bold text-secondary">File Sertifikat (Max 10MB)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-file-pdf text-danger"></i></span>
                            <input type="file" name="file_sertifikat" class="form-control border-start-0 ps-0 rounded-end-3" accept=".pdf" required>
                        </div>
                    </div>

                    <div class="p-3 mb-4 rounded-3 bg-light border border-dashed">
                        <p class="mb-0 x-small text-muted italic">Setelah diunggah, klien akan menerima notifikasi dan dapat langsung mengunduh sertifikat dari dashboard mereka.</p>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="py-2 btn btn-light w-100 rounded-3 small fw-bold" data-bs-dismiss="modal">Batal</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="py-2 shadow-sm btn btn-success w-100 rounded-3 small fw-bold">
                                <i class="fas fa-check-circle me-1"></i> Terbitkan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .fw-800 { font-weight: 800; }
    .text-deep-forest { color: #1a2e2a; }
    .bg-soft-success { background-color: #ecfdf5; }
    .bg-soft-warning { background-color: #fffbeb; }
    .x-small { font-size: 0.7rem; }
    .italic { font-style: italic; }
</style>
@endsection
