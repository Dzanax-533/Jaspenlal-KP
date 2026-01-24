@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- Header Tetap Sama --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold text-deep-forest">Pemeriksaan Berkas Klien</h4>
            <p class="mb-0 text-muted small">
                Klien: <strong>{{ $pendaftaran->user->name }}</strong> |
                ID: <span class="fw-bold text-dark">{{ $pendaftaran->no_pendaftaran }}</span> |
                <span class="px-3 border badge bg-soft-primary text-primary">Level {{ $pendaftaran->progress_level }}</span>
            </p>
        </div>
        <div class="gap-2 d-flex">
            <a href="{{ route('konsultan.dashboard') }}" class="border btn btn-light btn-sm rounded-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4 overflow-hidden border-0 shadow-sm card rounded-4">
                <div class="py-3 bg-white card-header border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-file-alt me-2 text-primary"></i>Daftar Dokumen Persyaratan</h6>
                    <span class="x-small text-muted">Hanya menampilkan 6 dokumen wajib</span>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="bg-light">
                            <tr class="x-small fw-bold text-muted text-uppercase">
                                <th class="py-3 ps-4">Nama Dokumen</th>
                                <th class="text-center">Pratinjau</th>
                                <th class="text-center">Status Validasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $listWajib = [
                                    'nib' => 'NIB (Nomor Induk Berusaha)',
                                    'surat_permohonan' => 'Surat Permohonan',
                                    'formulir_pendaftaran' => 'Formulir Pendaftaran',
                                    'dokumen_penyelia' => 'Dokumen Penyelia Halal',
                                    'manual_sjph' => 'Manual SJPH',
                                    'izin_edar' => 'Izin Edar (PIRT/MD)'
                                ];
                            @endphp

                            @foreach($listWajib as $key => $label)
                                @php $doc = $pendaftaran->dokumens->where('nama_dokumen', $key)->first(); @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold small text-dark">{{ $label }}</div>
                                        @if($doc && $doc->catatan_revisi)
                                            <div class="px-2 py-1 mt-1 rounded x-small text-danger bg-soft-danger d-inline-block">
                                                <i class="fas fa-comment-dots me-1"></i> Catatan: {{ $doc->catatan_revisi }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($doc)
                                            <a href="{{ route('konsultan.evaluasi.view.file', $doc->id) }}" target="_blank" class="px-3 btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="fas fa-eye me-1"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted x-small italic">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($doc)
                                            @if($doc->status == 'approved')
                                                <span class="px-3 badge bg-soft-success text-success rounded-pill">Valid</span>
                                            @elseif($doc->status == 'rejected')
                                                <span class="px-3 badge bg-soft-danger text-danger rounded-pill">Ditolak</span>
                                            @else
                                                <span class="px-3 badge bg-soft-warning text-warning rounded-pill">Pending</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($doc)
                                            <button class="border btn btn-sm btn-light rounded-circle" data-bs-toggle="modal" data-bs-target="#modalValidasi{{ $doc->id }}">
                                                <i class="fas fa-pen-nib text-primary"></i>
                                            </button>
                                        @else
                                            <i class="fas fa-times text-muted"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Widget Status --}}
        <div class="col-lg-4">
            <div class="mb-4 bg-white border-0 shadow-sm card rounded-4 position-sticky" style="top: 20px;">
                <div class="p-4 card-body">
                    <h6 class="mb-3 fw-bold">Status Pemeriksaan</h6>
                    @php
                        $wajibKeys = ['nib', 'surat_permohonan', 'formulir_pendaftaran', 'dokumen_penyelia', 'manual_sjph', 'izin_edar'];
                        $done = $pendaftaran->dokumens->whereIn('nama_dokumen', $wajibKeys)->where('status', 'approved')->count();
                        $isReady = ($done >= 6);
                    @endphp

                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Progres Berkas</small>
                        <span class="badge {{ $isReady ? 'bg-success' : 'bg-warning' }} rounded-pill">{{ $done }}/6 Valid</span>
                    </div>
                    <div class="mb-4 progress rounded-pill" style="height: 10px;">
                        <div class="progress-bar {{ $isReady ? 'bg-success' : 'bg-primary progress-bar-striped progress-bar-animated' }}"
                            style="width: {{ ($done/6)*100 }}%"></div>
                    </div>

                    @if($isReady)
                        <div class="p-3 border-0 alert alert-success rounded-4 small">
                            <i class="fas fa-check-double me-2"></i> <strong>Sempurna!</strong> Semua dokumen wajib telah divalidasi. Sistem otomatis memindahkan klien ke <strong>Level 6 (Evaluasi Bahan)</strong>.
                        </div>
                    @else
                        <div class="p-3 border-0 alert alert-light rounded-4 small border-start border-warning border-4">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Pastikan ke-6 dokumen di samping berstatus <strong>Valid</strong> agar klien dapat melanjutkan ke pengisian daftar bahan.
                        </div>
                    @endif
                </div>
            </div>
        </div>

{{-- MODAL VALIDASI PER ITEM --}}
@foreach($pendaftaran->dokumens as $doc)
<div class="modal fade" id="modalValidasi{{ $doc->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('konsultan.evaluasi.validasi.dokumen', $doc->id) }}" method="POST" class="border-0 shadow modal-content rounded-4">
            @csrf
            <div class="px-4 pt-4 pb-0 border-0 modal-header">
                <h6 class="mb-0 fw-bold">Validasi: {{ strtoupper(str_replace('_', ' ', $doc->nama_dokumen)) }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-4 modal-body">
                <div class="mb-4">
                    <label class="mb-2 small fw-bold text-muted">Tentukan Status</label>
                    <div class="gap-2 d-flex">
                        {{-- DISESUAIKAN: value="approved" --}}
                        <input type="radio" class="btn-check" name="status" id="v{{ $doc->id }}" value="approved" {{ $doc->status == 'approved' ? 'checked' : '' }} required>
                        <label class="py-2 btn btn-outline-success rounded-3 flex-fill" for="v{{ $doc->id }}">
                            <i class="fas fa-check-circle me-1 text-success icon-active"></i> Valid (Approve)
                        </label>

                        <input type="radio" class="btn-check" name="status" id="r{{ $doc->id }}" value="rejected" {{ $doc->status == 'rejected' ? 'checked' : '' }} required>
                        <label class="py-2 btn btn-outline-danger rounded-3 flex-fill" for="r{{ $doc->id }}">
                            <i class="fas fa-times-circle me-1 text-danger icon-active"></i> Tolak
                        </label>
                    </div>
                </div>
                <div class="mb-0">
                    <label class="mb-2 small fw-bold text-muted">Catatan Peninjauan</label>
                    <textarea name="catatan" class="shadow-sm form-control rounded-3 border-light bg-light" rows="3" placeholder="Berikan catatan jika ditolak atau perlu perbaikan...">{{ $doc->catatan_revisi }}</textarea>
                </div>
            </div>
            <div class="p-4 pt-0 border-0 modal-footer">
                <button type="submit" class="py-2 shadow-sm btn btn-primary w-100 rounded-3 fw-bold">
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
    .bg-soft-info { background-color: #e0f2fe; }
    .x-small { font-size: 0.7rem; }
    .text-deep-forest { color: #1a2e2a; }

    .btn-check:checked + .btn-outline-success { background-color: #10b981; color: white; border-color: #10b981; }
    .btn-check:checked + .btn-outline-danger { background-color: #ef4444; color: white; border-color: #ef4444; }
    .btn-check:checked + label i { color: white !important; }
</style>
@endsection
