{{-- DASHBOARD --}}
<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('konsultan.dashboard') ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('konsultan.dashboard') }}">
        <i class="fas fa-user-tie me-2" style="width: 20px;"></i> Dashboard Konsultan
    </a>
</li>

{{-- GRUP PENGECEKAN TEKNIS --}}
<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold"
    style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Pengecekan Teknis
</li>

<li class="nav-item">
    {{-- Aktif jika berada di list dokumen ATAU sedang mereview dokumen klien tertentu --}}
    <a class="py-2 nav-link {{ request()->routeIs('konsultan.evaluasi.dokumen') || (request()->routeIs('konsultan.evaluasi.show') && $pendaftaran->progress_level == 3) ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('konsultan.evaluasi.dokumen') }}">
        <i class="fas fa-file-medical me-2" style="width: 20px;"></i> Validasi Dokumen
    </a>
</li>

<li class="nav-item">
    {{-- Aktif jika berada di list bahan ATAU sedang mengevaluasi bahan klien tertentu --}}
    <a class="py-2 nav-link {{ request()->routeIs('konsultan.evaluasi.bahan') || (request()->routeIs('konsultan.evaluasi.show') && $pendaftaran->progress_level == 4) ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('konsultan.evaluasi.bahan') }}">
        <i class="fas fa-microscope me-2" style="width: 20px;"></i> Evaluasi Bahan
    </a>
</li>

{{-- GRUP AUDIT LAPANGAN --}}
<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold"
    style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Audit Lapangan
</li>

<li class="nav-item">
    {{-- Menggunakan wildcard '*' agar tetap active saat di list maupun di form upload LHA --}}
    <a class="py-2 nav-link {{ request()->routeIs('konsultan.audit.*') ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('konsultan.audit.index') }}">
        <i class="fas fa-clipboard-check me-2" style="width: 20px;"></i> Laporan Hasil Audit
    </a>
</li>
