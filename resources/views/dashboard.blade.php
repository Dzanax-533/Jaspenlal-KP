@extends('layouts.app')

@section('content')
<div class="container-fluid py-2">

    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-800 text-deep-forest mb-1">
                @if(Auth::user()->role == 'admin') Ringkasan Eksekutif
                @elseif(Auth::user()->role == 'keuangan') Monitor Arus Kas
                @elseif(Auth::user()->role == 'konsultan') Panel Penilaian Teknis
                @else Halo, {{ Auth::user()->name }}! @endif
            </h3>
            <p class="text-muted small">
                Status sistem hari ini: {{ date('d F Y') }} • Peran: <span class="badge bg-soft-emerald text-emerald text-uppercase">{{ Auth::user()->role }}</span>
            </p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        @if(Auth::user()->role == 'admin')
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm text-center">
                    <div class="avatar-circle mx-auto mb-2 bg-soft-emerald text-emerald"><i class="fas fa-users"></i></div>
                    <h4 class="fw-bold mb-0">{{ $stats['total_klien'] ?? 0 }}</h4>
                    <small class="text-muted fw-bold">TOTAL KLIEN</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm text-center text-white bg-primary">
                    <div class="avatar-circle mx-auto mb-2 bg-white text-primary"><i class="fas fa-file-signature"></i></div>
                    <h4 class="fw-bold mb-0">{{ $stats['total_pendaftar'] ?? 0 }}</h4>
                    <small class="opacity-75 fw-bold">PENDAFTARAN</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm text-center">
                    <div class="avatar-circle mx-auto mb-2 bg-warning text-white"><i class="fas fa-gavel"></i></div>
                    <h4 class="fw-bold mb-0">{{ $stats['menunggu_sidang'] ?? 0 }}</h4>
                    <small class="text-muted fw-bold">ANTREAN SIDANG</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm text-center">
                    <div class="avatar-circle mx-auto mb-2 bg-info text-white"><i class="fas fa-certificate"></i></div>
                    <h4 class="fw-bold mb-0">{{ $stats['siap_sertifikat'] ?? 0 }}</h4>
                    <small class="text-muted fw-bold">SIAP TERBIT</small>
                </div>
            </div>

        @elseif(Auth::user()->role == 'klien')
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold text-deep-forest mb-0">Status Pendaftaran Terakhir</h6>
                            <span class="badge bg-soft-emerald text-emerald rounded-pill px-3">{{ $pendaftaran->status ?? 'Belum Ada' }}</span>
                        </div>
                        <h5 class="fw-800 mb-1 text-primary">{{ $pendaftaran->no_pendaftaran ?? 'N/A' }}</h5>
                        <div class="progress mt-3 rounded-pill" style="height: 12px;">
                            <div class="progress-bar bg-primary" style="width: {{ (($pendaftaran->progress_level ?? 0) / 9) * 100 }}%"></div>
                        </div>
                        <p class="small text-muted mt-2">Level {{ $pendaftaran->progress_level ?? 0 }} dari 9 Tahapan Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-deep-forest text-white border-0 shadow-sm h-100 p-4">
                    <h5 class="fw-bold">Butuh Bantuan?</h5>
                    <p class="small text-white-50">Hubungi konsultan kami jika ada kendala.</p>
                    <a href="#" class="btn btn-light btn-sm fw-bold">Chat WhatsApp</a>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-deep-forest">
                        @if(Auth::user()->role == 'klien') <i class="fas fa-tasks me-2"></i> Timeline Proses
                        @else <i class="fas fa-list me-2"></i> Aktivitas Terakhir @endif
                    </h6>
                </div>
                <div class="card-body">
                    @if(Auth::user()->role == 'klien')
                        @include('layouts.partials.timeline-klien') {{-- Pindahkan logic timeline ke partial agar rapi --}}
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr class="small text-muted">
                                        <th>NOMOR</th>
                                        <th>KLIEN</th>
                                        <th>LEVEL</th>
                                        <th>STATUS</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($antrean ?? $pendaftaran_terbaru ?? [] as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item->no_pendaftaran }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td><span class="badge bg-light text-dark">Lvl {{ $item->progress_level }}</span></td>
                                        <td><span class="badge bg-soft-emerald text-emerald">{{ $item->status }}</span></td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted p-4">Tidak ada data pendaftaran terbaru.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus hub ini */
    .avatar-circle { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
    .bg-primary { background-color: var(--primary-emerald) !important; }
    .text-primary { color: var(--primary-emerald) !important; }
</style>
@endsection
