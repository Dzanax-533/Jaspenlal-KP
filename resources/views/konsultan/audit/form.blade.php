@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- Breadcrumb & Header --}}
    <div class="mb-4 row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('konsultan.audit.index') }}" class="text-decoration-none">Daftar Audit</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengerjaan LHA</li>
                </ol>
            </nav>
            <h4 class="fw-bold text-deep-forest">Penyusunan Laporan Hasil Audit (LHA)</h4>
            <p class="text-muted small">ID Pendaftaran: <span class="fw-bold text-primary">{{ $pendaftaran->no_pendaftaran }}</span></p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Sisi Kiri: Form Input --}}
        <div class="col-lg-7">
            <div class="border-0 shadow-sm card rounded-4">
                <div class="p-4 card-body">
                    {{-- FIXED: Form Action mengarah ke rute upload yang benar --}}
                    <form action="{{ route('konsultan.audit.upload', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" id="formLha">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Informasi Klien</label>
                            <div class="p-3 bg-light rounded-3">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="d-block text-muted x-small">Nama Klien</small>
                                        <span class="fw-bold small">{{ $pendaftaran->user->name }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="d-block text-muted x-small">Perusahaan</small>
                                        <span class="fw-bold small">{{ $pendaftaran->klienDetail->nama_perusahaan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="file_lha" class="form-label fw-bold small text-muted text-uppercase">Unggah Berkas LHA (PDF)</label>
                            <div class="p-4 text-center border-2 border-dashed upload-wrapper rounded-4 bg-light position-relative" id="dropzone">
                                <input type="file" name="file_lha" id="file_lha" class="top-0 opacity-0 cursor-pointer form-control position-absolute w-100 h-100 start-0" accept=".pdf" required onchange="previewFileName(this)">
                                <div id="upload-placeholder">
                                    <i class="mb-3 fas fa-file-pdf fs-1 text-danger"></i>
                                    <h6 class="mb-1 fw-bold">Klik atau seret file PDF LHA di sini</h6>
                                    <p class="mb-0 x-small text-muted">Pastikan file telah ditandatangani (Maks. 10MB)</p>
                                </div>
                                <div id="file-chosen" class="d-none">
                                    <i class="mb-3 fas fa-check-circle fs-1 text-emerald"></i>
                                    <h6 class="mb-1 fw-bold text-emerald" id="file-name-text">File Terpilih</h6>
                                    <button type="button" class="btn btn-sm btn-link text-muted x-small" onclick="resetUpload()">Ganti File</button>
                                </div>
                            </div>
                            @error('file_lha') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="catatan_audit" class="form-label fw-bold small text-muted text-uppercase">Catatan Auditor (Opsional)</label>
                            <textarea name="catatan_audit" id="catatan_audit" class="border-0 form-control bg-light rounded-3" rows="5" placeholder="Tambahkan catatan penting terkait temuan audit lapangan..."></textarea>
                        </div>

                        {{-- UPDATED: Sinkronisasi Teks ke Level 8 --}}
                        <div class="border-0 alert alert-info rounded-4 small d-flex align-items-start">
                            <i class="mt-1 fas fa-info-circle me-3"></i>
                            <div>
                                <strong>Alur Selanjutnya:</strong> Setelah dikirim, data akan diteruskan ke <strong>Level 8 (Sidang Fatwa)</strong>. Admin akan menjadwalkan sidang berdasarkan dokumen LHA yang Anda unggah.
                            </div>
                        </div>

                        <div class="mt-4 d-grid">
                            {{-- UPDATED: Button dengan Loading State --}}
                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg rounded-4 fw-bold shadow-sm-primary transition-hover">
                                <span id="btnText"><i class="fas fa-paper-plane me-2"></i> Kirim Laporan</span>
                                <span id="btnLoading" class="d-none"><i class="fas fa-spinner fa-spin me-2"></i> Mengirim Laporan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Panduan --}}
        <div class="col-lg-5">
            <div class="mb-4 text-white border-0 shadow-sm card rounded-4 bg-deep-forest">
                <div class="p-4 card-body">
                    <h6 class="mb-3 fw-bold"><i class="fas fa-list-check me-2"></i>Checklist Kelengkapan LHA</h6>
                    <ul class="opacity-75 list-unstyled small">
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Ringkasan hasil audit lapangan</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Matriks bahan & produk terkini</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Foto dokumentasi proses produksi</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Berita acara pemeriksaan (BAP)</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Rekomendasi Auditor</li>
                    </ul>
                </div>
            </div>

            <div class="border-0 shadow-sm card rounded-4">
                <div class="p-4 card-body">
                    <h6 class="mb-3 fw-bold text-deep-forest">Bantuan Konsultasi</h6>
                    <p class="mb-4 small text-muted">Menemui kendala teknis dalam penyusunan LHA atau perbedaan data lapangan?</p>
                    <a href="#" class="btn btn-outline-secondary btn-sm w-100 rounded-3">
                        <i class="fas fa-headset me-2"></i> Hubungi Koordinator Auditor
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .text-deep-forest { color: #1a2e2a; }
    .bg-deep-forest { background-color: #1a2e2a; }
    .x-small { font-size: 0.75rem; }
    .text-emerald { color: #10b981 !important; }
    .cursor-pointer { cursor: pointer; }
    .upload-wrapper { transition: all 0.3s ease; border: 2px dashed #dee2e6; }
    .upload-wrapper:hover { border-color: #10b981; background-color: #f0fdf4 !important; }
    .shadow-sm-primary { box-shadow: 0 4px 14px 0 rgba(14, 165, 233, 0.3); }
    .transition-hover { transition: all 0.2s ease; }
    .transition-hover:hover { transform: translateY(-2px); }
</style>

<script>
    // Preview file name
    function previewFileName(input) {
        const placeholder = document.getElementById('upload-placeholder');
        const fileChosen = document.getElementById('file-chosen');
        const fileNameText = document.getElementById('file-name-text');

        if (input.files && input.files[0]) {
            placeholder.classList.add('d-none');
            fileChosen.classList.remove('d-none');
            fileNameText.textContent = input.files[0].name;
        }
    }

    // Reset upload
    function resetUpload() {
        const input = document.getElementById('file_lha');
        const placeholder = document.getElementById('upload-placeholder');
        const fileChosen = document.getElementById('file-chosen');

        input.value = '';
        placeholder.classList.remove('d-none');
        fileChosen.classList.add('d-none');
    }

    // Handle Button Loading on Submit
    document.getElementById('formLha').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');

        btn.classList.add('disabled');
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
    });
</script>
@endsection
