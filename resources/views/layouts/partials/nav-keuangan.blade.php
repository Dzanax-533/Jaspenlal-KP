<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('keuangan.dashboard') }}">
        <i class="fas fa-chart-pie me-2" style="width: 20px;"></i> Dashboard Keuangan
    </a>
</li>

<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold"
    style="letter-spacing: 0.05em; font-size: 0.6rem;">
    Verifikasi Transaksi
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('keuangan.termin1') ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('keuangan.termin1') }}">
        <i class="fas fa-money-bill-wave me-2" style="width: 20px;"></i> Termin 1 (DP 60%)
    </a>
</li>

<li class="nav-item">
    <a class="nav-link py-2 {{ request()->routeIs('keuangan.termin2') ? 'active' : '' }}"
       style="font-size: 0.8rem;" href="{{ route('keuangan.termin2') }}">
        <i class="fas fa-check-double me-2" style="width: 20px;"></i> Termin 2 (Pelunasan 40%)
    </a>
</li>
