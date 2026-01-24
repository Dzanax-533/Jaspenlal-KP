@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 row align-items-center">
        <div class="col-md-8">
            <h4 class="mb-1 fw-800 text-deep-forest">Unggah Dokumen Sertifikasi</h4>
            <p class="text-muted small">Lengkapi berkas persyaratan untuk divalidasi oleh Konsultan Pendamping (Level 5).</p>
        </div>
        <div class="col-md-4 text-md-end">
            {{-- Badge Counter otomatis mengikuti jumlah listDokumen di Controller --}}
            <span class="px-3 py-2 bg-white border shadow-sm badge text-dark rounded-pill small">
                <i class="fas fa-file-alt me-1 text-emerald"></i> Terunggah: {{ count($dokumenUploaded) }} / {{ count($listDokumen) }}
            </span>
        </div>
    </div>

    {{-- CEK PENUGASAN KONSULTAN --}}
    @if($pendaftaran->progress_level < 5)
        <div class="px-4 py-5 mb-4 text-center bg-white border-0 shadow-sm card rounded-4">
            <div class="card-body">
                <div class="p-4 mb-3 d-inline-block bg-soft-warning rounded-circle">
                    <i class="fas fa-user-shield fs-1 text-warning"></i>
                </div>
                <h5 class="fw-bold text-dark">Fitur Belum Terbuka</h5>
                <p class="mx-auto text-muted" style="max-width: 500px;">
                    Akses unggah dokumen akan terbuka secara otomatis setelah Admin menunjuk <strong>Konsultan Pendamping</strong> untuk pendaftaran Anda (Level 5).
                </p>
                <a href="{{ route('dashboard') }}" class="px-4 btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    @endif

    <div class="row g-4" style="{{ $pendaftaran->progress_level < 5 ? 'filter: blur(2px); pointer-events: none; opacity: 0.6; user-select: none;' : '' }}">
        <div class="col-lg-12">
            <div class="overflow-hidden bg-white border-0 shadow-sm card rounded-4">
                @if($pendaftaran->konsultan)
                <div class="p-3 bg-soft-emerald border-bottom d-flex justify-content-between align-items-center">
                    <small class="text-emerald fw-bold">
                        <i class="fas fa-user-check me-2"></i>Konsultan Pendamping: {{ $pendaftaran->konsultan->name }}
                    </small>
                    <span class="badge bg-emerald rounded-pill small">Pemeriksaan Level 5</span>
                </div>
                @endif

                <div class="p-0 card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr class="small fw-bold text-muted text-uppercase">
                                    <th class="py-3 ps-4" style="width: 50%;">Nama Dokumen</th>
                                    <th class="text-center">Status Validasi</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop otomatis mengikuti listDokumen dari Controller --}}
                                @foreach($listDokumen as $key => $label)
                                <tr class="border-bottom">
                                    <td class="py-3 ps-4">
                                        <div class="fw-bold text-dark small">{{ $label }}</div>
                                        @if(isset($dokumenUploaded[$key]) && $dokumenUploaded[$key]['status'] == 'rejected')
                                            <div class="mt-2 p-2 rounded bg-soft-danger border-start border-danger border-3">
                                                <small class="text-danger fw-bold d-block">
                                                    <i class="fas fa-comment-dots me-1"></i> CATATAN REVISI KONSULTAN:
                                                </small>
                                                <p class="mb-0 small text-dark italic">
                                                    "{{ $dokumenUploaded[$key]['catatan_revisi'] ?? 'Tidak ada catatan spesifik, harap hubungi konsultan.' }}"
                                                </p>
                                            </div>
                                        @else
                                            <small class="text-muted">Format: PDF, JPG, PNG (Maks 5MB)</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(isset($dokumenUploaded[$key]))
                                            @php
                                                $doc = $dokumenUploaded[$key];
                                                $status = $doc['status'] ?? 'pending';
                                            @endphp

                                            @if($status == 'approved')
                                                <span class="px-3 py-2 badge bg-success rounded-pill shadow-sm">
                                                    <i class="fas fa-check-circle me-1"></i> Valid
                                                </span>
                                            @elseif($status == 'rejected')
                                                <span class="px-3 py-2 badge bg-danger rounded-pill shadow-sm"
                                                    data-bs-toggle="tooltip" title="{{ $doc['catatan_revisi'] }}">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> Perlu Revisi
                                                </span>
                                            @else
                                                <span class="px-3 py-2 badge bg-info text-white rounded-pill shadow-sm">
                                                    <i class="fas fa-hourglass-half me-1"></i> Menunggu Verifikasi
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-3 py-2 badge bg-light text-muted rounded-pill border">
                                                <i class="fas fa-times me-1"></i> Belum Diunggah
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="gap-2 d-flex justify-content-end align-items-center">
                                            @if(isset($dokumenUploaded[$key]))
                                                {{-- Tombol Lihat --}}
                                                <a href="{{ route('klien.dokumen.view', ['path' => $dokumenUploaded[$key]['file_path']]) }}"
                                                   target="_blank"
                                                   class="px-3 btn btn-sm btn-outline-info rounded-3"
                                                   title="Lihat Dokumen">
                                                     <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Tombol Hapus: Terkunci jika sudah APPROVED --}}
                                                @if(($dokumenUploaded[$key]['status_verifikasi'] ?? 'pending') != 'approved')
                                                    <form action="{{ route('klien.dokumen.destroy', $dokumenUploaded[$key]['id'] ?? 0) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="px-3 border btn btn-sm btn-light rounded-3 btn-show-upload"
                                                        data-jenis="{{ $key }}"
                                                        data-label="{{ $label }}"
                                                        title="Ganti Dokumen">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                @else
                                                    <button class="px-3 border btn btn-sm btn-light disabled rounded-3" title="Dokumen Valid (Terkunci)">
                                                        <i class="fas fa-lock text-muted"></i>
                                                    </button>
                                                @endif
                                            @else
                                                {{-- Tombol Unggah Pertama Kali --}}
                                                <button type="button" class="px-4 shadow-sm btn btn-sm btn-primary rounded-3 btn-show-upload"
                                                    data-jenis="{{ $key }}"
                                                    data-label="{{ $label }}">
                                                    <i class="fas fa-upload me-1"></i> Unggah
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('klien.dokumen.upload') }}" method="POST" enctype="multipart/form-data" class="border-0 shadow-lg modal-content rounded-4">
            @csrf
            <input type="hidden" name="jenis" id="modal_jenis">
            <div class="border-0 modal-header bg-light">
                <h6 class="modal-title fw-bold" id="modal_label">Unggah Dokumen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-4 modal-body">
                <div class="mb-3 text-center">
                    <label class="mb-3 small fw-bold text-muted d-block">Pilih file berkas (Max 5MB)</label>
                    <div class="p-4 border-2 border-dashed upload-zone rounded-4 bg-light position-relative">
                        <input type="file" name="file" class="custom-file-input" onchange="updateFileName(this)" accept=".pdf,.jpg,.jpeg,.png" required style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 2;">
                        <div class="py-2">
                            <i class="mb-2 fas fa-cloud-upload-alt fs-2 text-primary"></i>
                            <p class="mb-0 small fw-bold text-dark" id="fileNameDisplay">Klik atau pilih file</p>
                        </div>
                    </div>
                </div>
                <div class="mb-0 border-0 alert alert-info small rounded-3">
                    <i class="fas fa-info-circle me-2"></i> Pastikan dokumen terbaca jelas dalam format PDF atau Gambar.
                </div>
            </div>
            <div class="p-4 pt-0 border-0 modal-footer">
                <button type="submit" class="py-2 shadow-sm btn btn-primary w-100 rounded-pill fw-bold">Simpan Dokumen</button>
            </div>
        </form>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .bg-soft-emerald { background-color: #ecfdf5 !important; }
    .text-emerald { color: #10b981 !important; }
    .bg-soft-danger { background-color: #fee2e2 !important; }
    .bg-soft-secondary { background-color: #f8fafc !important; }
    .bg-soft-warning { background-color: #fff9db !important; }
    .upload-zone { transition: all 0.2s ease-in-out; border: 2px dashed #cbd5e1; }
    .upload-zone:hover { border-color: #3b82f6; background-color: #eff6ff !important; }
    .x-small { font-size: 0.75rem; }
    .bg-emerald { background-color: #10b981; color: white; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const uploadModalElement = document.getElementById('uploadModal');
    const uploadModal = new bootstrap.Modal(uploadModalElement);

    document.addEventListener('click', function (event) {
        const btn = event.target.closest('.btn-show-upload');
        if (btn) {
            const jenis = btn.getAttribute('data-jenis');
            const label = btn.getAttribute('data-label');

            document.getElementById('modal_jenis').value = jenis;
            document.getElementById('modal_label').textContent = 'Unggah ' + label;
            document.getElementById('fileNameDisplay').textContent = 'Klik untuk pilih file';

            uploadModalElement.querySelector('input[type="file"]').value = '';
            uploadModal.show();
        }
    });
});

function updateFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileNameDisplay').textContent = input.files[0].name;
    }
}
</script>
@endsection
