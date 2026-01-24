@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- Header --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 fw-800 text-deep-forest">Daftar Bahan & Produk</h4>
            <p class="mb-0 text-muted small">Inputkan bahan-bahan yang digunakan dalam proses produksi (Level 6).</p>
        </div>

        {{-- Tombol hanya aktif jika berada di Level 6 dan belum divalidasi final ke Level 7 --}}
        @if($pendaftaran->progress_level == 6)
        <button class="px-4 shadow-sm btn btn-emerald rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBahan">
            <i class="fas fa-plus me-2"></i> Tambah Bahan
        </button>
        @endif
    </div>

    @if(session('error'))
        <div class="mb-4 border-0 shadow-sm alert alert-danger rounded-4 d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-3 fs-4"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- WIDGET STATUS PEMERIKSAAN --}}
    <div class="row mb-4">
        <div class="col-12">
            @php
                $totalBahan = $bahans->count();
                $verifiedBahan = $bahans->where('status_validasi', 'verified')->count();
                $isAllVerified = ($totalBahan > 0 && $totalBahan == $verifiedBahan);
            @endphp

            <div class="border-0 shadow-sm card rounded-4 {{ $isAllVerified ? 'bg-soft-emerald border-start border-emerald border-4' : 'bg-white' }}">
                <div class="p-4 card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle {{ $isAllVerified ? 'bg-white text-emerald' : 'bg-light text-muted' }} me-3 shadow-sm">
                            <i class="fas {{ $isAllVerified ? 'fa-clipboard-check' : 'fa-info-circle' }} fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-dark">Status Pemeriksaan Bahan</h6>
                            <p class="mb-0 text-muted small">
                                @if($totalBahan == 0)
                                    Silakan klik tombol <strong>Tambah Bahan</strong> untuk menginputkan bahan produksi Anda.
                                @elseif($isAllVerified)
                                    <span class="text-emerald fw-bold">Semua bahan telah divalidasi!</span>
                                    @if(Auth::user()->isKlien())
                                        Anda tinggal menunggu jadwal Audit Lapangan dari Konsultan.
                                    @else
                                        Silakan klik tombol <strong>Jadwalkan Audit</strong> di bawah.
                                    @endif
                                @else
                                    Baru <strong>{{ $verifiedBahan }} dari {{ $totalBahan }}</strong> bahan yang disetujui.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden border-0 shadow-sm card rounded-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="bg-light text-muted small fw-bold text-uppercase">
                    <tr>
                        <th class="py-3 ps-4">Nama Bahan</th>
                        <th>Produsen</th>
                        <th>No. Sertifikat / Masa Berlaku</th>
                        <th class="text-center">Status Validasi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahans as $bahan)
                    <tr class="border-bottom">
                        <td class="ps-4">
                            <span class="fw-bold text-dark small d-block">{{ $bahan->nama_bahan }}</span>
                            @if($bahan->status_validasi == 'rejected')
                                <small class="text-danger fw-bold"><i class="fas fa-comment-dots me-1"></i> Alasan: {{ $bahan->catatan ?? 'Data tidak sesuai' }}</small>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $bahan->produsen }}</td>
                        <td>
                            {{-- SINKRONISASI: Menggunakan nomor_sertifikat sesuai Model --}}
                            <span class="mb-1 border badge bg-light text-dark fw-normal">
                                {{ $bahan->nomor_sertifikat ?? 'Tanpa Sertifikat' }}
                            </span>
                            @if($bahan->masa_berlaku)
                                <small class="d-block text-muted" style="font-size: 0.7rem;">Berlaku s/d: {{ \Carbon\Carbon::parse($bahan->masa_berlaku)->format('d/m/Y') }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($bahan->status_validasi == 'verified')
                                <span class="px-3 py-2 border border-opacity-25 badge bg-soft-emerald text-emerald rounded-pill small fw-bold border-emerald">
                                    <i class="fas fa-check-circle me-1"></i> Approved
                                </span>
                            @elseif($bahan->status_validasi == 'rejected')
                                <span class="px-3 py-2 border border-opacity-25 badge bg-soft-danger text-danger rounded-pill small fw-bold border-danger">
                                    <i class="fas fa-times-circle me-1"></i> Perlu Revisi
                                </span>
                            @else
                                <span class="px-3 py-2 border border-opacity-25 badge bg-soft-warning text-warning rounded-pill small fw-bold border-warning">
                                    <i class="fas fa-hourglass-half me-1"></i> Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if(Auth::user()->isKlien() && $bahan->status_validasi != 'verified' && $pendaftaran->progress_level == 6)
                                <form action="{{ route('klien.bahan.destroy', $bahan->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 btn btn-sm btn-light text-danger rounded-pill" onclick="return confirm('Hapus bahan ini?')">
                                        <i class="mx-1 fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @elseif(Auth::user()->isKonsultan() && $pendaftaran->progress_level == 6)
                                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalValidasiBahan{{ $bahan->id }}">
                                    Review
                                </button>
                            @else
                                <i class="opacity-50 fas fa-lock text-muted" title="Data terkunci"></i>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted small">Belum ada bahan yang diinputkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOMBOL FINALISASI (KHUSUS KONSULTAN) --}}
    @if(Auth::user()->isKonsultan() && $pendaftaran->progress_level == 6 && $isAllVerified)
    <div class="mt-4 p-4 border-0 shadow-sm card rounded-4 bg-soft-primary">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold text-primary mb-1">Audit Lapangan Siap Dijadwalkan</h6>
                <p class="mb-0 text-muted small">Semua bahan sudah diverifikasi. Silakan tentukan tanggal kunjungan audit.</p>
            </div>
            <button class="btn btn-primary px-4 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalAudit">
                <i class="fas fa-calendar-alt me-2"></i> Jadwalkan Audit Lapangan
            </button>
        </div>
    </div>
    @endif
</div>

{{-- MODAL TAMBAH BAHAN (KLIEN) --}}
@if(Auth::user()->isKlien())
<div class="modal fade" id="modalTambahBahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow modal-content rounded-4">
            <form action="{{ route('klien.bahan.store') }}" method="POST">
                @csrf
                <div class="p-4 border-0 modal-header">
                    <h5 class="mb-0 fw-bold text-deep-forest">Tambah Bahan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="p-4 pt-0 modal-body">
                    <div class="mb-3">
                        <label class="label-muted-caps">NAMA BAHAN</label>
                        <input type="text" name="nama_bahan" class="p-3 border-0 form-control bg-light rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="label-muted-caps">PRODUSEN</label>
                        <input type="text" name="produsen" class="p-3 border-0 form-control bg-light rounded-3" required>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="label-muted-caps">NO. SERTIFIKAT</label>
                            {{-- SINKRONISASI: nomor_sertifikat --}}
                            <input type="text" name="nomor_sertifikat" class="p-3 border-0 form-control bg-light rounded-3" placeholder="ID00xxxxxx">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="label-muted-caps">MASA BERLAKU</label>
                            <input type="date" name="masa_berlaku" class="p-3 border-0 form-control bg-light rounded-3">
                        </div>
                    </div>
                </div>
                <div class="p-4 border-0 modal-footer">
                    <button type="submit" class="py-3 shadow-sm btn btn-emerald w-100 rounded-3 fw-bold">Simpan Bahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- MODAL FINAL JADWAL AUDIT (KONSULTAN) --}}
@if(Auth::user()->isKonsultan() && $isAllVerified)
<div class="modal fade" id="modalAudit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('konsultan.evaluasi.validasi.bahan', $pendaftaran->id) }}" method="POST" class="border-0 shadow modal-content rounded-4">
            @csrf
            <input type="hidden" name="final_step" value="1">
            <div class="p-4 border-0 modal-header">
                <h6 class="mb-0 fw-bold">Penjadwalan Audit Lapangan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-4 modal-body">
                <label class="label-muted-caps">TANGGAL & WAKTU AUDIT</label>
                <input type="datetime-local" name="tgl_audit" class="form-control rounded-3 border-light bg-light" required>
                <small class="text-muted d-block mt-2">Jadwal ini akan tampil di dashboard klien.</small>
            </div>
            <div class="p-4 pt-0 border-0 modal-footer">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">Kirim Jadwal & Mulai Audit</button>
            </div>
        </form>
    </div>
</div>
@endif

<style>
    .label-muted-caps { font-size: 0.65rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.1em; text-transform: uppercase; display: block; margin-bottom: 0.5rem; }
    .bg-soft-emerald { background-color: #ecfdf5; }
    .bg-soft-primary { background-color: #f0f7ff; }
    .text-emerald { color: #10b981; }
    .text-deep-forest { color: #064e3b; }
    .btn-emerald { background-color: #10b981; color: white; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .fw-800 { font-weight: 800; }
</style>
@endsection
