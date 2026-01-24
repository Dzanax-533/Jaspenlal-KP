@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="row justify-content-center">
        <div class="col-xl-11">

            {{-- Bagian Atas: Breadcrumb & Tombol Download --}}
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="p-0 mb-0 bg-transparent breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-bold text-emerald small" aria-current="page">Invoice Penagihan</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center">
                    <a href="{{ route('klien.transaksi.download_pdf', $pendaftaran->id) }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold me-3 shadow-sm transition-hover">
                        <i class="fas fa-file-pdf me-1"></i> DOWNLOAD PDF
                    </a>

                    @php
                        $statusVerif = $pembayaranSaatIni->status_verifikasi ?? 'belum_bayar';
                    @endphp

                    @if($statusVerif == 'belum_bayar')
                        <span class="px-3 py-2 border border-opacity-25 shadow-sm badge bg-soft-warning text-warning rounded-pill small fw-bold border-warning">
                            <i class="fas fa-clock me-1"></i> MENUNGGU PEMBAYARAN TERMIN {{ $termin }}
                        </span>
                    @elseif($statusVerif == 'pending')
                        <span class="px-3 py-2 border border-opacity-25 shadow-sm badge bg-soft-info text-info rounded-pill small fw-bold border-info">
                            <i class="fas fa-hourglass-half me-1"></i> MENUNGGU VERIFIKASI KEUANGAN
                        </span>
                    @elseif($statusVerif == 'verified')
                        <span class="px-3 py-2 border border-opacity-25 shadow-sm badge bg-soft-emerald text-emerald rounded-pill small fw-bold border-emerald">
                            <i class="fas fa-check-circle me-1"></i> PEMBAYARAN TERMIN {{ $termin }} BERHASIL
                        </span>
                    @elseif($statusVerif == 'rejected')
                        <span class="px-3 py-2 border border-opacity-25 shadow-sm badge bg-soft-danger text-danger rounded-pill small fw-bold border-danger">
                            <i class="fas fa-exclamation-circle me-1"></i> PEMBAYARAN DITOLAK
                        </span>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden bg-white border-0 shadow-lg card rounded-4">
                <div class="px-4 py-4 border-0 card-header px-md-5" style="background: linear-gradient(135deg, #1a2e2a, #10b981); border-radius: 0;">
                    <div class="text-white d-flex justify-content-between align-items-center">
                        <div>
                            <span class="px-3 mb-2 bg-white bg-opacity-25 badge fw-light">OFFICIAL INVOICE</span>
                            <h3 class="mb-0 fw-800 letter-spacing-tight">PENAGIHAN JASA</h3>
                        </div>
                        <div class="text-end">
                            <h5 class="mb-0 fw-bold">#{{ $pendaftaran->no_pendaftaran }}</h5>
                            <small class="opacity-75">{{ $pendaftaran->created_at->format('d F Y') }}</small>
                        </div>
                    </div>
                </div>

                <div class="p-4 card-body p-md-5">
                    {{-- Info Pengirim & Penerima --}}
                    <div class="pb-4 mb-5 row border-bottom g-4">
                        <div class="col-md-6 border-end-md">
                            <label class="label-muted-caps">DITUJUKAN KEPADA</label>
                            <div class="mt-2 d-flex align-items-center">
                                <div class="shadow-sm avatar-circle-sm me-3 bg-soft-emerald text-emerald">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-5">{{ Auth::user()->name }}</h6>
                                    <p class="mb-0 text-muted small">{{ Auth::user()->klienDetail->nama_perusahaan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <label class="label-muted-caps">METODE PEMBAYARAN (BANK MANDIRI)</label>
                            <div class="mt-2 payment-box d-inline-block text-md-end">
                                <div class="mb-1 d-flex align-items-center justify-content-md-end">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" height="22" class="me-2">
                                    <h5 class="mb-0 fw-800 text-dark letter-spacing-tight">123-456-7890</h5>
                                </div>
                                <p class="mb-0 text-muted small">A/N <span class="fw-bold text-dark text-uppercase">PT Konsultan Halal Indonesia</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-5">
                        {{-- Sisi Kiri: RINCIAN DETAIL (Update di sini agar tidak Rp 0) --}}
                        <div class="col-lg-7">
                            <label class="mb-3 label-muted-caps text-emerald">RINCIAN UNIT & LAYANAN</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-borderless">
                                    <thead class="bg-light border-bottom">
                                        <tr class="small text-muted fw-bold text-uppercase" style="letter-spacing: 1px;">
                                            <th class="py-3 ps-3" style="width: 70%;">Deskripsi Item</th>
                                            <th class="py-3 text-end pe-3">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 1. Biaya Dasar --}}
                                        <tr class="border-bottom">
                                            <td class="py-4 ps-3">
                                                <h6 class="mb-1 fw-bold text-dark">Biaya Dasar Paket (Skala {{ ucfirst($pendaftaran->user->klienDetail->skala_usaha) }})</h6>
                                                <small class="text-muted">Pendampingan penuh untuk paket {{ $pendaftaran->paket->nama_paket }}</small>
                                            </td>
                                            <td class="text-end pe-3 fw-bold text-dark">
                                                Rp {{ number_format($pendaftaran->biaya_dasar, 0, ',', '.') }}
                                            </td>
                                        </tr>

                                        {{-- 2. Tambahan Menu (Hanya muncul jika > 0) --}}
                                        @if($pendaftaran->biaya_menu_tambahan > 0)
                                        <tr class="border-bottom">
                                            <td class="py-4 ps-3">
                                                <h6 class="mb-1 fw-bold text-dark">Tambahan Item Menu/Produk</h6>
                                                <small class="text-muted">Total: {{ $pendaftaran->total_menu }} Produk (Kapasitas standar 50 terlampaui)</small>
                                            </td>
                                            <td class="text-end pe-3 fw-bold text-danger">
                                                + Rp {{ number_format($pendaftaran->biaya_menu_tambahan, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endif

                                        {{-- 3. Tambahan Outlet (Hanya muncul jika > 0) --}}
                                        @if($pendaftaran->biaya_outlet_tambahan > 0)
                                        <tr class="border-bottom">
                                            <td class="py-4 ps-3">
                                                <h6 class="mb-1 fw-bold text-dark">Penambahan Fasilitas/Outlet</h6>
                                                <small class="text-muted">Total: {{ $pendaftaran->total_outlet }} Gerai/Lokasi</small>
                                            </td>
                                            <td class="text-end pe-3 fw-bold text-danger">
                                                + Rp {{ number_format($pendaftaran->biaya_outlet_tambahan, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endif

                                        {{-- 4. Akomodasi --}}
                                        <tr class="bg-light bg-opacity-50">
                                            <td class="py-3 ps-3">
                                                <h6 class="mb-0 fw-bold text-muted small text-uppercase">
                                                    <i class="fas fa-truck-pickup me-2"></i>Akomodasi & Transportasi
                                                </h6>
                                            </td>
                                            <td class="text-end pe-3 fw-bold small {{ $pendaftaran->luar_jabodetabek ? 'text-warning' : 'text-emerald' }}">
                                                {{ $pendaftaran->luar_jabodetabek ? 'DITANGGUNG KLIEN' : 'INCLUDED' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Sisi Kanan: Summary & Upload Bukti --}}
                        <div class="col-lg-5">
                            <div class="p-4 border bg-light rounded-4">
                                <label class="mb-4 label-muted-caps text-center d-block">Kalkulasi Akhir</label>

                                <div class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted small">Total Nilai Kontrak</span>
                                    <span class="small fw-bold">Rp {{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}</span>
                                </div>

                                <div class="p-4 bg-white shadow-sm rounded-4 mb-4 border-start border-4 border-emerald text-center">
                                    <small class="text-emerald fw-800 text-uppercase d-block mb-1" style="font-size: 0.65rem;">Tagihan Termin {{ $termin }}:</small>
                                    <h3 class="mb-0 fw-800 text-emerald">Rp {{ number_format($nominal, 0, ',', '.') }}</h3>
                                    <small class="text-muted opacity-75">{{ $termin == '1' ? 'Uang Muka 60% (Aktivasi)' : 'Pelunasan 40%' }}</small>
                                </div>

                                @if($statusVerif == 'belum_bayar' || $statusVerif == 'rejected')
                                    <form action="{{ route('klien.transaksi.store', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" id="formPembayaran">
                                        @csrf
                                        <input type="hidden" name="nominal" value="{{ $nominal }}">
                                        <input type="hidden" name="termin" value="{{ $termin }}">

                                        <div class="mb-3">
                                            <label for="buktiTransfer" class="upload-zone w-100 rounded-4 transition-hover bg-white border-2">
                                                <input type="file" name="bukti_transfer" class="custom-file-input" id="buktiTransfer" required accept="image/*">
                                                <div class="text-center p-3">
                                                    <i class="fas fa-camera text-emerald fs-3 mb-2"></i>
                                                    <p class="mb-0 small fw-bold text-dark" id="file-name">Unggah Bukti Transfer</p>
                                                    <span class="x-small text-muted">Klik untuk memilih foto</span>
                                                </div>
                                            </label>
                                        </div>

                                        <button type="submit" id="btnSubmit" class="py-3 btn btn-emerald w-100 fw-bold text-white rounded-3 shadow-emerald">
                                            <span class="btn-text">KONFIRMASI PEMBAYARAN <i class="fas fa-paper-plane ms-2"></i></span>
                                            <span class="btn-loader d-none"><i class="fas fa-spinner fa-spin me-2"></i> MENGIRIM...</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="p-4 text-center bg-white border rounded-4 shadow-sm">
                                        <div class="mb-3 p-3 bg-soft-emerald rounded-circle d-inline-flex">
                                            <i class="fas fa-check-double text-emerald fs-4"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Bukti Terkirim</h6>
                                        <p class="text-muted x-small mb-0">Menunggu peninjauan tim keuangan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-5 py-3 border-0 card-footer bg-light d-flex justify-content-between align-items-center">
                    <small class="text-muted"><i class="fas fa-check-shield text-emerald me-1"></i> Transaksi Terenkripsi Aman</small>
                    <small class="text-muted">Bantuan: <a href="#" class="fw-bold text-emerald text-decoration-none">Hubungi Support</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --emerald: #10b981; }
    .text-emerald { color: var(--emerald) !important; }
    .btn-emerald, .bg-emerald { background-color: var(--emerald) !important; }
    .bg-soft-emerald { background-color: #ecfdf5 !important; }
    .fw-800 { font-weight: 800; }
    .label-muted-caps { font-size: 0.65rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.12em; text-transform: uppercase; }
    .upload-zone { border: 2px dashed #e2e8f0; position: relative; cursor: pointer; transition: 0.3s; min-height: 100px; display: flex; align-items: center; justify-content: center; }
    .upload-zone:hover { border-color: var(--emerald); background-color: #f8fafc; }
    .custom-file-input { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 5; }
    .shadow-emerald { box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25); }
    .x-small { font-size: 0.75rem; }
    .transition-hover:hover { transform: translateY(-2px); }
</style>

<script>
    document.getElementById('buktiTransfer')?.addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            document.getElementById('file-name').innerText = e.target.files[0].name;
            document.getElementById('file-name').classList.add('text-emerald');
        }
    });

    document.getElementById('formPembayaran')?.addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.querySelector('.btn-text').classList.add('d-none');
        btn.querySelector('.btn-loader').classList.remove('d-none');
    });
</script>
@endsection
