@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-1 fw-800 text-deep-forest">Legalitas Perusahaan</h4>
                    <p class="mb-0 text-muted small">Lengkapi data di bawah ini untuk memulai pendaftaran sertifikasi.</p>
                </div>
                <span class="px-3 py-2 badge bg-soft-emerald text-emerald rounded-pill small fw-bold">
                    <i class="fas fa-shield-halal me-1"></i> TAHAP 0: PRA-SYARAT
                </span>
            </div>

            <div class="overflow-hidden border-0 shadow-sm card rounded-4">
                <div class="p-0 card-body">
                    <div class="row g-0">
                        {{-- Sisi Kiri: Informasi Onboarding --}}
                        <div class="p-4 col-md-4 bg-soft-emerald d-none d-md-flex flex-column justify-content-between border-end" style="border-color: rgba(16, 185, 129, 0.1) !important;">
                            <div>
                                <div class="mb-3 bg-white shadow-sm avatar-circle text-emerald d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 12px;">
                                    <i class="fas fa-building fs-5"></i>
                                </div>
                                <h5 class="fw-bold text-deep-forest">Verifikasi Data</h5>
                                <p class="small text-muted" style="line-height: 1.6;">Pastikan data <strong>Nama Perusahaan</strong> dan <strong>NPWP</strong> sesuai dengan dokumen resmi untuk mempermudah proses audit.</p>

                                <ul class="p-0 mt-4 list-unstyled">
                                    <li class="mb-3 d-flex align-items-start small text-muted">
                                        <i class="mt-1 fas fa-check-circle text-emerald me-2"></i>
                                        <span>Data tersimpan aman di server terenkripsi.</span>
                                    </li>
                                    <li class="d-flex align-items-start small text-muted">
                                        <i class="mt-1 fas fa-check-circle text-emerald me-2"></i>
                                        <span>Digunakan sebagai dasar penerbitan sertifikat.</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-auto">
                                <div class="p-2 bg-white shadow-sm d-flex align-items-center rounded-3">
                                    <i class="fas fa-lock text-emerald me-2"></i>
                                    <span style="font-size: 0.7rem;" class="text-muted fw-medium">Secure SSL 256-bit Connection</span>
                                </div>
                            </div>
                        </div>

                        {{-- Sisi Kanan: Form --}}
                        <div class="p-4 bg-white col-md-8 p-lg-5">
                            <form action="{{ route('klien.profil.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    {{-- Nama Perusahaan --}}
                                    <div class="mb-2 col-12">
                                        <label class="form-label-custom">NAMA RESMI PERUSAHAAN</label>
                                        <div class="input-group custom-input-group @error('nama_perusahaan') is-invalid @enderror">
                                            <span class="bg-transparent input-group-text"><i class="fas fa-industry"></i></span>
                                            <input type="text" name="nama_perusahaan"
                                                   class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                                   placeholder="Contoh: PT. Maju Jaya Abadi"
                                                   value="{{ old('nama_perusahaan', $profil->nama_perusahaan ?? '') }}" required>
                                        </div>
                                        @error('nama_perusahaan')
                                            <div class="mt-1 text-danger small" style="font-size: 0.75rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NPWP --}}
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label-custom">NPWP PERUSAHAAN</label>
                                        <div class="input-group custom-input-group @error('npwp') is-invalid @enderror">
                                            <span class="bg-transparent input-group-text"><i class="fas fa-fingerprint"></i></span>
                                            <input type="text" name="npwp" id="npwp_mask"
                                                   class="form-control @error('npwp') is-invalid @enderror"
                                                   placeholder="00.000.000.0-000.000"
                                                   value="{{ old('npwp', $profil->npwp ?? '') }}" required>
                                        </div>
                                        @error('npwp')
                                            <div class="mt-1 text-danger small" style="font-size: 0.75rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Skala Usaha (Menyesuaikan Logic Biaya) --}}
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label-custom">SKALA USAHA</label>
                                        <div class="input-group custom-input-group @error('skala_usaha') is-invalid @enderror">
                                            <span class="bg-transparent input-group-text"><i class="fas fa-chart-pie"></i></span>
                                            <select name="skala_usaha" class="form-select @error('skala_usaha') is-invalid @enderror" required>
                                                <option value="" disabled selected>Pilih Skala...</option>
                                                <option value="kecil" {{ old('skala_usaha', $profil->skala_usaha ?? '') == 'kecil' ? 'selected' : '' }}>Kecil</option>
                                                <option value="menengah" {{ old('skala_usaha', $profil->skala_usaha ?? '') == 'menengah' ? 'selected' : '' }}>Menengah</option>
                                                <option value="besar" {{ old('skala_usaha', $profil->skala_usaha ?? '') == 'besar' ? 'selected' : '' }}>Besar</option>
                                            </select>
                                        </div>
                                        @error('skala_usaha')
                                            <div class="mt-1 text-danger small" style="font-size: 0.75rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="mb-4 col-12">
                                        <label class="form-label-custom">ALAMAT KANTOR PUSAT</label>
                                        <div class="input-group custom-input-group @error('alamat_perusahaan') is-invalid @enderror">
                                            <span class="pt-2 bg-transparent input-group-text align-items-start"><i class="fas fa-map-marker-alt"></i></span>
                                            <textarea name="alamat_perusahaan" class="form-control @error('alamat_perusahaan') is-invalid @enderror"
                                                      rows="3" placeholder="Jl. Nama Jalan No. 123, Kota, Provinsi..." required>{{ old('alamat_perusahaan', $profil->alamat_perusahaan ?? '') }}</textarea>
                                        </div>
                                        @error('alamat_perusahaan')
                                            <div class="mt-1 text-danger small" style="font-size: 0.75rem;">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="pt-3 col-12 border-top">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="text-muted small">
                                                <i class="fas fa-info-circle me-1"></i> Data dapat diubah nantinya
                                            </span>
                                            <button type="submit" class="px-4 py-2 shadow-sm btn btn-primary fw-bold">
                                                Simpan Profil <i class="fas fa-check-circle ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Style tetap sama, dengan sedikit tambahan untuk error state --}}
<style>
    .form-label-custom { font-size: 0.7rem; font-weight: 800; color: #64748b; letter-spacing: 0.08em; margin-bottom: 0.5rem; display: block; }
    .custom-input-group { background-color: #ffffff; border-radius: 12px; transition: all 0.3s ease; }
    .custom-input-group .input-group-text { border: 1px solid #e2e8f0; border-right: none; color: #94a3b8; padding-left: 1rem; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .custom-input-group .form-control, .custom-input-group .form-select { border: 1px solid #e2e8f0; border-left: none; padding: 0.6rem 1rem 0.6rem 0.2rem; font-size: 0.95rem; font-weight: 500; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    .custom-input-group:focus-within .input-group-text, .custom-input-group:focus-within .form-control, .custom-input-group:focus-within .form-select { border-color: #10b981; background-color: #ffffff; }
    .custom-input-group:focus-within { box-shadow: 0 4px 12px rgba(16, 185, 129, 0.08); }

    /* Error State */
    .custom-input-group.is-invalid .input-group-text, .custom-input-group.is-invalid .form-control { border-color: #ef4444; }
    .bg-soft-emerald { background-color: #f0fdf4; }
    .text-emerald { color: #10b981; }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function(){
        // Format NPWP Indonesia
        $('#npwp_mask').mask('00.000.000.0-000.000');

        // Memastikan input hanya huruf besar untuk Nama Perusahaan
        $('input[name="nama_perusahaan"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection
