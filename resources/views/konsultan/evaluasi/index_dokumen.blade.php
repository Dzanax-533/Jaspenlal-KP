@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-deep-forest mb-1">Daftar Validasi Dokumen</h4>
            <p class="text-muted small">Tinjau kelengkapan berkas administrasi klien (Level 3).</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="py-3 ps-4">Klien / Perusahaan</th>
                        <th>Dokumen Terunggah</th>
                        <th>Status Terakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendampingans as $p)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                            <small class="text-muted">{{ $p->klienDetail->nama_perusahaan ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-soft-primary text-primary px-3 rounded-pill">
                                <i class="fas fa-file-alt me-1"></i> {{ $p->dokumens->count() }} Berkas
                            </span>
                        </td>
                        <td><small class="text-muted italic">{{ $p->status }}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('konsultan.evaluasi.show', $p->id) }}" class="btn btn-sm btn-primary rounded-3 px-3">
                                    <i class="fas fa-search me-1"></i> Periksa
                                </a>
                                {{-- Tombol Revisi memicu modal di dashboard jika perlu, atau buat modal lokal --}}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">Tidak ada antrean validasi dokumen saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
