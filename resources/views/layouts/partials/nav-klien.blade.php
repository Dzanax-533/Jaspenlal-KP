@php
    // Eager load pembayarans untuk performa
    $pendaftaranAktif = Auth::user()->pendaftarans()->with('pembayarans')->latest()->first();
    $progress = $pendaftaranAktif->progress_level ?? 0;

    // Cek Verifikasi Pelunasan (Termin 2) - Hanya jika ada yang statusnya 'verified'
    $lunasVerified = $pendaftaranAktif ? $pendaftaranAktif->pembayarans->where('termin', 2)->where('status_verifikasi', 'verified')->isNotEmpty() : false;

    // Logika Gembok
    $isDokumenLocked = ($progress < 5);
    $isBahanLocked = ($progress < 6);
    $isSertifikatLocked = ($progress < 10 || !$lunasVerified);
@endphp

<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('dashboard*') ? 'active' : '' }}" style="font-size: 0.8rem;" href="{{ route('dashboard') }}">
        <i class="fas fa-home me-2" style="width: 20px;"></i> Dashboard
    </a>
</li>

<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Pendaftaran & Keuangan
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('klien.pendaftaran*') ? 'active' : '' }}" style="font-size: 0.8rem;" href="{{ route('klien.pendaftaran.create') }}">
        <i class="fas fa-file-signature me-2" style="width: 20px;"></i> Buat Pendaftaran
    </a>
</li>

<li class="nav-item">
    @if($pendaftaranAktif)
        <a class="nav-link py-2 {{ request()->routeIs('klien.transaksi*') ? 'active' : '' }}" style="font-size: 0.8rem;" href="{{ route('klien.transaksi.invoice', $pendaftaranAktif->id) }}">
            <i class="fas fa-file-invoice-dollar me-2" style="width: 20px;"></i> Tagihan & Pembayaran
        </a>
    @else
        <a class="py-2 opacity-50 nav-link disabled text-muted" style="font-size: 0.8rem;">
            <i class="fas fa-file-invoice-dollar me-2"></i> Tagihan & Pembayaran <i class="fas fa-lock float-end mt-1" style="font-size: 0.7rem;"></i>
        </a>
    @endif
</li>

<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Proses Sertifikasi
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ $isDokumenLocked ? 'disabled text-muted opacity-50' : (request()->routeIs('klien.dokumen*') ? 'active fw-bold' : '') }}"
       style="font-size: 0.8rem;" href="{{ !$isDokumenLocked ? route('klien.dokumen.index') : 'javascript:void(0)' }}">
        <i class="fas fa-folder-open me-2" style="width: 20px;"></i> Dokumen Persyaratan
        @if($isDokumenLocked) <i class="mt-1 fas fa-lock float-end" style="font-size: 0.7rem;"></i> @endif
    </a>
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ $isBahanLocked ? 'disabled text-muted opacity-50' : (request()->routeIs('klien.bahan*') ? 'active fw-bold' : '') }}"
       style="font-size: 0.8rem;" href="{{ !$isBahanLocked ? route('klien.bahan.index') : 'javascript:void(0)' }}">
        <i class="fas fa-flask me-2" style="width: 20px;"></i> Bahan & Produk
        @if($isBahanLocked) <i class="mt-1 fas fa-lock float-end" style="font-size: 0.7rem;"></i> @endif
    </a>
</li>

<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Monitoring & Hasil
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ $isSertifikatLocked ? 'disabled text-muted opacity-50' : (request()->routeIs('klien.sertifikat*') ? 'active fw-bold' : '') }}"
       style="font-size: 0.8rem;" href="{{ !$isSertifikatLocked ? route('klien.sertifikat.index') : 'javascript:void(0)' }}">
        <i class="fas fa-award me-2 text-warning" style="width: 20px;"></i> Sertifikat Saya
        @if($isSertifikatLocked) <i class="mt-1 fas fa-lock float-end" style="font-size: 0.7rem;"></i> @endif
    </a>
</li>
