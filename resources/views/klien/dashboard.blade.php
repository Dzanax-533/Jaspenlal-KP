@extends('layouts.app')

@section('content')

<div class="py-4 container-fluid px-md-5">
    {{-- Header Section --}}
    <div class="mb-4 row align-items-center">
        <div class="col-md-6">
            <h3 class="mb-1 fw-800 text-deep-forest">Dashboard Klien</h3>
            <p class="text-muted small">Pantau status sertifikasi halal produk Anda secara real-time.</p>
        </div>
        <div class="col-md-6 text-md-end">
            @if(!$pendaftaran || $pendaftaran->progress_level == 10)
                <a href="{{ route('klien.pendaftaran.create') }}" class="px-4 py-2 shadow-sm btn btn-primary rounded-4">
                    <i class="fas fa-plus me-2"></i> Daftar Sertifikasi Baru
                </a>
            @endif
        </div>
    </div>

    {{-- Info Utama & Progress --}}
    <div class="mb-4 row">
        <div class="col-12">
            <div class="overflow-hidden border-0 shadow-sm card rounded-4">
                <div class="p-4 card-body">
                    @if($pendaftaran)
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h5 class="mb-1 fw-bold text-deep-forest">{{ $pendaftaran->no_pendaftaran }}</h5>
                                <div class="gap-3 d-flex align-items-center">
                                    <p class="mb-0 text-muted small">Paket: <span class="fw-bold text-primary">{{ $pendaftaran->paket->nama_paket ?? 'Reguler' }}</span></p>
                                    <p class="mb-0 text-muted small">Tahap: <span class="border badge bg-light text-dark">{{ $pendaftaran->progress_level }} / 10</span></p>
                                </div>
                            </div>
                            <div class="mt-3 col-md-5 text-md-end mt-md-0">
                                <span class="badge {{ $pendaftaran->progress_level == 10 ? 'bg-success' : 'bg-soft-emerald text-emerald' }} rounded-pill px-3 py-2 border shadow-sm">
                                    @if($pendaftaran->progress_level < 10)
                                        <i class="fas fa-sync-alt fa-spin me-1"></i>
                                    @else
                                        <i class="fas fa-check-circle me-1"></i>
                                    @endif
                                    {{ $pendaftaran->status }}
                                </span>
                            </div>
                        </div>

                        {{-- Progress Bar Dinamis --}}
                        <div class="mt-4">
                            <div class="mb-2 d-flex justify-content-between">
                                <span class="uppercase small fw-bold text-muted">Persentase Selesai</span>
                                <span class="small fw-bold text-emerald">{{ number_format(($pendaftaran->progress_level / 10) * 100, 0) }}%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 12px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-emerald {{ $pendaftaran->progress_level < 10 ? 'progress-bar-striped progress-bar-animated' : '' }}"
                                     style="width: {{ ($pendaftaran->progress_level / 10) * 100 }}%"></div>
                            </div>
                        </div>

                        {{-- AREA NOTIFIKASI AUDIT LAPANGAN (LEVEL 7) --}}
                        @if($pendaftaran->progress_level == 7)
                            @if($pendaftaran->tgl_audit)
                                <div class="mt-4 border-0 shadow-sm card rounded-4" style="background: linear-gradient(45deg, #10b981, #059669); color: white;">
                                    <div class="p-4 card-body">
                                        <div class="row align-items-center">
                                            <div class="mb-3 col-md-auto mb-md-0">
                                                <div class="p-3 bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-calendar-check fa-2x text-emerald"></i>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h5 class="mb-1 fw-bold">Jadwal Audit Lapangan Telah Ditetapkan!</h5>
                                                <p class="mb-0 opacity-90">Konsultan pendamping (<strong>{{ $pendaftaran->konsultan->name ?? 'Konsultan' }}</strong>) akan melakukan kunjungan audit pada:</p>
                                                <div class="mt-3">
                                                    <span class="px-3 py-2 bg-white border badge text-emerald rounded-pill fs-6 me-2 shadow-sm">
                                                        <i class="far fa-calendar-alt me-2"></i> {{ \Carbon\Carbon::parse($pendaftaran->tgl_audit)->translatedFormat('l, d F Y') }}
                                                    </span>
                                                    <span class="px-3 py-2 bg-white border badge text-emerald rounded-pill fs-6 shadow-sm">
                                                        <i class="far fa-clock me-2"></i> {{ \Carbon\Carbon::parse($pendaftaran->tgl_audit)->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 border-0 shadow-sm card rounded-4 bg-soft-info border-start border-info border-4">
                                    <div class="p-4 card-body d-flex align-items-center">
                                        <div class="p-3 bg-white shadow-sm rounded-circle me-4">
                                            <i class="fas fa-clock fa-2x text-info"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Menunggu Penjadwalan Audit</h5>
                                            <p class="mb-0 text-muted">Berkas & bahan diverifikasi. Konsultan sedang mengatur jadwal <strong>Audit Lapangan</strong>.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- AREA AKSI DINAMIS (Action Center) --}}
                        <div class="p-3 mt-4 border border-dashed rounded-4 bg-light d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="mb-3 d-flex align-items-center mb-md-0">
                                <div class="p-2 text-center bg-white shadow-sm rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas {{ $pendaftaran->progress_level == 10 ? 'fa-medal text-success' : 'fa-bullhorn text-primary' }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold small">{{ $pendaftaran->progress_level == 10 ? 'Selamat! Sertifikasi Selesai' : 'Instruksi Langkah '.$pendaftaran->progress_level.':' }}</h6>
                                    <p class="mb-0 text-muted x-small">
                                        @php
                                            $bayarDP = $pendaftaran->pembayarans->where('termin', 1)->first();
                                            $bayarLunas = $pendaftaran->pembayarans->where('termin', 2)->first();
                                        @endphp

                                        @if($pendaftaran->progress_level == 2 && $bayarDP && $bayarDP->status_verifikasi == 'pending')
                                            <span class="text-primary fw-bold"><i class="fas fa-spinner fa-spin me-1"></i> Bukti DP sedang diperiksa Keuangan.</span>
                                        @elseif($pendaftaran->progress_level == 9 && $bayarLunas && $bayarLunas->status_verifikasi == 'pending')
                                            <span class="text-primary fw-bold"><i class="fas fa-spinner fa-spin me-1"></i> Bukti Pelunasan sedang diperiksa Keuangan.</span>
                                        @else
                                            {{ $pendaftaran->progress_level == 10 ? 'Anda dapat mengunduh sertifikat halal resmi Anda.' : 'Sistem mendeteksi Anda perlu melakukan aksi di bawah ini.' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="gap-2 d-grid d-md-flex">
                                {{-- LEVEL 2: DP --}}
                                @if($pendaftaran->progress_level == 2)
                                    @if(!$bayarDP || $bayarDP->status_verifikasi == 'rejected')
                                        <a href="{{ route('klien.transaksi.store') }}" class="px-4 shadow-sm btn btn-primary rounded-pill fw-bold btn-sm"><i class="fas fa-wallet me-2"></i> Bayar DP</a>
                                    @else
                                        <span class="px-3 py-2 badge bg-soft-warning text-warning rounded-pill x-small border">Menunggu Verifikasi Keuangan</span>
                                    @endif

                                {{-- LEVEL 5 & 6 --}}
                                @elseif($pendaftaran->progress_level == 5)
                                    <a href="{{ route('klien.dokumen.index') }}" class="px-4 shadow-sm btn btn-primary rounded-pill fw-bold btn-sm"><i class="fas fa-file-upload me-2"></i> Lengkapi Dokumen</a>
                                @elseif($pendaftaran->progress_level == 6)
                                    <a href="{{ route('klien.bahan.index') }}" class="px-4 shadow-sm btn btn-warning rounded-pill fw-bold btn-sm text-dark"><i class="fas fa-vial me-2"></i> Isi Daftar Bahan</a>

                                {{-- LEVEL 9: Pelunasan --}}
                                @elseif($pendaftaran->progress_level == 9)
                                    @if(!$bayarLunas || $bayarLunas->status_verifikasi == 'rejected')
                                        <div class="gap-2 d-flex">
                                            @if($pendaftaran->file_ketetapan_halal)
                                                <a href="{{ asset('storage/' . $pendaftaran->file_ketetapan_halal) }}" target="_blank" class="px-3 btn btn-outline-primary rounded-pill btn-sm fw-bold"><i class="fas fa-file-download me-1"></i> Ketetapan Halal</a>
                                            @endif
                                            <a href="{{ route('klien.transaksi.store') }}?termin=2" class="px-4 shadow-sm btn btn-danger rounded-pill fw-bold btn-sm"><i class="fas fa-hand-holding-usd me-2"></i> Bayar Pelunasan</a>
                                        </div>
                                    @else
                                        <span class="px-3 py-2 badge bg-soft-warning text-warning rounded-pill x-small border">Menunggu Verifikasi Pelunasan</span>
                                    @endif

                                {{-- LEVEL 10: Download Sertifikat --}}
                                @elseif($pendaftaran->progress_level == 10)
                                    @if($pendaftaran->file_sertifikat && \Storage::disk('public')->exists($pendaftaran->file_sertifikat))
                                        <a href="{{ asset('storage/' . $pendaftaran->file_sertifikat) }}" target="_blank" class="px-4 shadow-sm btn btn-success rounded-pill fw-bold btn-sm">
                                            <i class="text-white fas fa-award me-2"></i> UNDUH SERTIFIKAT (PDF)
                                        </a>
                                    @else
                                        <span class="px-3 py-2 badge bg-soft-secondary text-muted rounded-pill x-small border">Sertifikat Belum Diunggah Admin</span>
                                    @endif
                                @else
                                    <span class="italic text-muted x-small">Berkas sedang diproses sistem.</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" height="100" class="mb-3 opacity-25">
                            <h6 class="fw-bold">Selamat Datang!</h6>
                            <p class="text-muted small">Mulai pendaftaran sertifikasi halal pertama Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="row">
        <div class="col-12">
            <div class="p-4 overflow-hidden border-0 shadow-sm card rounded-4">
                <h6 class="mb-4 fw-bold text-deep-forest"><i class="fas fa-route me-2 text-success"></i>Alur Proses Sertifikasi (10 Tahap)</h6>
                @if($pendaftaran)
                    @include('layouts.partials.timeline-klien')
                @else
                    <div class="py-4 text-center border border-dashed text-muted small rounded-4">Timeline akan muncul setelah pendaftaran.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
