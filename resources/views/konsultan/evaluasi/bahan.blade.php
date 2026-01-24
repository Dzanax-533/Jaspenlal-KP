@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold text-deep-forest">Evaluasi Bahan & Titik Kritis</h4>
            <p class="text-muted small">Memeriksa daftar bahan yang digunakan oleh <strong>{{ $pendaftaran->user->name }}</strong></p>
        </div>
        <a href="{{ route('konsultan.evaluasi.bahan') }}" class="border btn btn-light btn-sm rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4 overflow-hidden border-0 shadow-sm card rounded-4">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="bg-light text-uppercase x-small fw-bold">
                            <tr>
                                <th class="py-3 ps-4">Nama Bahan</th>
                                <th>Produsen</th>
                                <th>No. Sertifikat</th>
                                <th>Masa Berlaku</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- SINKRONISASI: Menggunakan relasi 'bahans' --}}
                            @forelse($pendaftaran->bahans as $b)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold small text-dark">{{ $b->nama_bahan }}</div>
                                    @if($b->catatan)
                                        <div class="mt-1 px-2 py-1 rounded bg-soft-danger text-danger x-small border-start border-danger border-2">
                                            <i class="fas fa-comment-dots me-1"></i> {{ $b->catatan }}
                                        </div>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $b->produsen }}</td>
                                <td>
                                    {{-- FIX: Menggunakan nomor_sertifikat sesuai Model --}}
                                    <span class="border badge bg-light text-dark fw-normal">
                                        {{ $b->nomor_sertifikat ?? '-' }}
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    {{ $b->masa_berlaku ? \Carbon\Carbon::parse($b->masa_berlaku)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if($b->status_validasi == 'verified')
                                        <span class="px-3 badge bg-soft-success text-success rounded-pill">Verified</span>
                                    @elseif($b->status_validasi == 'rejected')
                                        <span class="px-3 badge bg-soft-danger text-danger rounded-pill">Rejected</span>
                                    @else
                                        <span class="px-3 badge bg-soft-warning text-warning rounded-pill">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="border btn btn-sm btn-light rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBahan{{ $b->id }}">
                                        <i class="fas fa-pen-nib text-primary"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-5 italic text-center text-muted small">Belum ada data bahan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- WIDGET JADWAL AUDIT --}}
        <div class="col-lg-4">
            <div class="border-0 border-4 shadow-sm card rounded-4 border-top border-warning position-sticky" style="top: 20px;">
                <div class="p-4 card-body">
                    <h6 class="mb-3 fw-bold"><i class="fas fa-calendar-alt me-2 text-warning"></i>Jadwal Audit Lapangan</h6>

                    @php
                        $totalBahan = $pendaftaran->bahans->count();
                        $verifiedBahan = $pendaftaran->bahans->where('status_validasi', 'verified')->count();
                        $isReady = ($totalBahan > 0 && $totalBahan === $verifiedBahan);
                    @endphp

                    <div class="mb-4 progress rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $totalBahan > 0 ? ($verifiedBahan/$totalBahan)*100 : 0 }}%"></div>
                    </div>

                    <form action="{{ route('konsultan.evaluasi.validasi.bahan', $pendaftaran->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="final_step" value="1">

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">TANGGAL KUNJUNGAN</label>
                            <input type="date" name="tgl_audit" class="border-0 form-control rounded-3 bg-light p-3"
                                   {{ !$isReady ? 'disabled' : '' }} required>

                            @if(!$isReady)
                                <div class="p-3 mt-3 border-0 alert bg-soft-danger rounded-3 x-small text-danger">
                                    <i class="fas fa-lock me-1"></i> Verifikasi semua bahan ({{ $verifiedBahan }}/{{ $totalBahan }}) untuk membuka fitur ini.
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="py-3 shadow btn btn-warning w-100 rounded-3 fw-bold text-dark {{ !$isReady ? 'disabled' : '' }}">
                            <i class="fas fa-truck-loading me-2"></i> Jadwalkan & Lanjut Audit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL VALIDASI PER ITEM --}}
@foreach($pendaftaran->bahans as $b)
<div class="modal fade" id="modalBahan{{ $b->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('konsultan.evaluasi.validasi.bahan', $b->id) }}" method="POST" class="border-0 shadow modal-content rounded-4">
            @csrf
            <div class="px-4 pt-4 border-0 modal-header">
                <h6 class="mb-0 fw-bold">Validasi: {{ $b->nama_bahan }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-4 modal-body">
                <div class="mb-4">
                    <label class="mb-2 small fw-bold text-muted d-block text-uppercase">Status Kelayakan</label>
                    <div class="gap-2 d-flex">
                        <input type="radio" class="btn-check" name="status" id="v{{ $b->id }}" value="verified" {{ $b->status_validasi == 'verified' ? 'checked' : '' }} required>
                        <label class="btn btn-outline-success flex-fill rounded-3 py-2" for="v{{ $b->id }}">
                            <i class="fas fa-check-circle me-1"></i> Verified
                        </label>

                        <input type="radio" class="btn-check" name="status" id="r{{ $b->id }}" value="rejected" {{ $b->status_validasi == 'rejected' ? 'checked' : '' }} required>
                        <label class="btn btn-outline-danger flex-fill rounded-3 py-2" for="r{{ $b->id }}">
                            <i class="fas fa-times-circle me-1"></i> Rejected
                        </label>
                    </div>
                </div>
                <div class="mb-0">
                    <label class="mb-2 small fw-bold text-muted text-uppercase">Catatan Auditor</label>
                    <textarea name="catatan" class="border-0 form-control bg-light rounded-3 p-3" rows="3" placeholder="Sebutkan alasan jika ditolak atau catatan kritis lainnya...">{{ $b->catatan }}</textarea>
                </div>
            </div>
            <div class="p-4 pt-0 border-0 modal-footer">
                <button type="submit" class="py-3 btn btn-primary w-100 rounded-3 fw-bold shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .bg-soft-success { background-color: #dcfce7; }
    .bg-soft-danger { background-color: #fee2e2; }
    .bg-soft-warning { background-color: #fef9c3; }
    .bg-soft-primary { background-color: #eff6ff; }
    .x-small { font-size: 0.7rem; }
    .text-deep-forest { color: #1a2e2a; }
    .italic { font-style: italic; }
</style>
@endsection
