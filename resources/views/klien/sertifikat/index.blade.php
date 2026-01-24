@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 row align-items-center">
        <div class="col-md-8">
            <h4 class="mb-1 fw-800 text-deep-forest">Sertifikat Halal Saya</h4>
            <p class="text-muted small">Daftar sertifikat resmi yang telah diterbitkan untuk pendaftaran Anda.</p>
        </div>
    </div>

    <div class="row">
        {{-- Langsung looping dari variabel pendaftaranSelesai yang dikirim controller --}}
        @forelse($pendaftaranSelesai as $p)
            <div class="mb-4 col-md-4">
                <div class="p-3 overflow-hidden text-center border-0 shadow-sm card rounded-4 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-3">
                                <div class="shadow-sm bg-soft-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-certificate fa-3x text-success"></i>
                                </div>
                            </div>
                            <h6 class="mb-1 fw-bold text-dark">{{ $p->no_pendaftaran }}</h6>
                            <p class="mb-2 small text-muted">Diterbitkan: {{ $p->updated_at->format('d F Y') }}</p>
                            <div class="mb-4">
                                <span class="badge bg-success rounded-pill px-3 shadow-sm">RESMI & TERVERIFIKASI</span>
                            </div>
                        </div>

                        {{-- Menggunakan asset() dengan link storage yang benar --}}
                        <a href="{{ asset('storage/'.$p->file_sertifikat) }}" target="_blank" class="shadow-sm btn btn-success rounded-pill w-100 fw-bold py-2 transition-hover">
                            <i class="fas fa-file-pdf me-2"></i> Lihat Sertifikat (PDF)
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-5 text-center col-12">
                <div class="mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" height="100" class="opacity-25">
                </div>
                <h6 class="text-muted fw-bold">Belum ada sertifikat yang tersedia.</h6>
                <p class="small text-muted">Sertifikat akan muncul di sini setelah status pendaftaran Anda dinyatakan "Selesai" (Level 10) oleh Admin.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4 mt-2">
                    Cek Progres Dashboard
                </a>
            </div>
        @endforelse
    </div>
</div>

<style>
    .bg-soft-success { background-color: #ecfdf5; }
    .text-deep-forest { color: #1a2e2a; }
    .fw-800 { font-weight: 800; }
    .transition-hover { transition: all 0.3s; }
    .transition-hover:hover { transform: scale(1.02); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2) !important; }
    .card:hover { transform: translateY(-5px); border: 1px solid #10b981 !important; }
</style>
@endsection
