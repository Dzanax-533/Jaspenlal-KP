@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-md-4">
    {{-- BARIS 1: WIDGET STATISTIK (Tetap sama) --}}
    <div class="row g-3 mb-4">
        {{-- ... Kode statistik Anda sebelumnya ... --}}
        <div class="col-md-2">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 border-bottom border-primary border-4">
                <div class="text-primary mb-2"><i class="fas fa-user-tag fa-lg"></i></div>
                <div class="small fw-bold text-muted text-uppercase">Plotting</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['pending_plotting'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 border-bottom border-warning border-4">
                <div class="text-warning mb-2"><i class="fas fa-gavel fa-lg"></i></div>
                <div class="small fw-bold text-muted text-uppercase">Sidang</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['pending_sidang'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 border-bottom border-success border-4">
                <div class="text-success mb-2"><i class="fas fa-certificate fa-lg"></i></div>
                <div class="small fw-bold text-muted text-uppercase">Terbit</div>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['pending_sertifikat'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100 bg-danger-soft border-bottom border-danger border-4">
                <div class="text-danger mb-2"><i class="fas fa-times-circle fa-lg"></i></div>
                <div class="small fw-bold text-muted text-uppercase">Pendaftaran Ditolak</div>
                <h3 class="fw-bold mb-0 text-danger">{{ $stats['total_ditolak'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <div class="text-dark mb-2"><i class="fas fa-users fa-lg"></i></div>
                <div class="small fw-bold text-muted text-uppercase">Total Klien</div>
                <h3 class="fw-bold mb-0">{{ $stats['total_klien'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    {{-- BARIS 2: PEMBAGIAN TABEL & HISTORY --}}
    <div class="row g-4">
        {{-- SISI KIRI: ANTREAN PENDAFTARAN --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-deep-forest"><i class="fas fa-list me-2 text-primary"></i>Antrean Pendaftaran Baru</h6>
                    <a href="{{ route('admin.operasional.plotting') }}" class="btn btn-sm btn-light rounded-pill px-3 border">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                                    <th class="ps-4 py-3">ID Reg</th>
                                    <th>Klien</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaranTerbaru as $row)
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <span class="small fw-bold text-primary">{{ $row->no_pendaftaran }}</span>
                                    </td>
                                    <td>
                                        <div class="small fw-bold text-dark">{{ $row->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;"><i class="far fa-calendar-alt me-1"></i>{{ $row->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary rounded-pill px-2 fw-medium" style="font-size: 0.65rem;">Level {{ $row->progress_level }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($row->progress_level == 4)
                                            <button type="button" class="btn btn-xs btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPlotting{{ $row->id }}">
                                                <i class="fas fa-user-plus me-1"></i> Plot
                                            </button>
                                        @else
                                            <i class="fas fa-ellipsis-h text-muted opacity-50"></i>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada antrean baru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: HISTORY PENOLAKAN --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-danger mb-0"><i class="fas fa-history me-2"></i>History Penolakan</h6>
                    <span class="badge bg-soft-danger text-danger rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">Log Terakhir</span>
                </div>
                <div class="card-body p-4">
                    <div class="timeline-container">
                        @forelse($logPenolakan as $log)
                        <div class="d-flex position-relative mb-4">
                            @if(!$loop->last)
                                <div class="position-absolute border-start" style="left: 17px; top: 35px; bottom: -20px; border-color: #f1f1f1 !important; border-width: 2px !important;"></div>
                            @endif
                            <div class="flex-shrink-0 z-index-2">
                                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                                    <i class="fas fa-times fa-xs"></i>
                                </div>
                            </div>
                            <div class="ms-3 w-100">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="small fw-800 mb-0 text-dark">{{ $log->user->name }}</h6>
                                    <span class="text-muted" style="font-size: 0.6rem;">{{ $log->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="bg-light p-3 rounded-3 border-start border-danger border-4 shadow-sm">
                                    <p class="small text-muted mb-0 italic" style="font-size: 0.72rem; line-height: 1.4;">
                                        <i class="fas fa-quote-left me-1 opacity-25"></i>
                                        {{ $log->keterangan ?? 'Dokumen tidak valid atau pembayaran tidak sesuai nominal.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/4436/4436481.png" height="60" class="mb-3 opacity-25">
                            <p class="small text-muted mb-0">Semua pendaftaran berjalan lancar.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan Modals di luar loop utama agar tidak merusak layout --}}
@foreach($pendaftaranTerbaru as $row)
    @if($row->progress_level == 4)
    <div class="modal fade" id="modalPlotting{{ $row->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form action="{{ route('admin.operasional.assign') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pendaftaran_id" value="{{ $row->id }}">
                    <div class="modal-body p-4">
                        <h6 class="fw-bold mb-3">Tugaskan Konsultan</h6>
                        <label class="x-small fw-bold text-muted text-uppercase mb-2">Pilih Konsultan Pelaksana</label>
                        <select name="konsultan_id" class="form-select rounded-3 shadow-sm mb-3" required>
                            <option value="">-- Pilih --</option>
                            @foreach($konsultans as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold py-2">Konfirmasi Plotting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
    .fw-800 { font-weight: 800; }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.08); }
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-danger { background-color: #fff1f2; }
    .btn-xs { padding: 0.25rem 0.6rem; font-size: 0.7rem; }
    .italic { font-style: italic; }
    .z-index-2 { z-index: 2; }
</style>
@endsection
