{{-- Dashboard Utama --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt me-2" style="width: 20px;"></i> Dashboard Admin
    </a>
</li>

{{-- Grup Manajemen Operasional --}}
<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;">
    Manajemen Operasional
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.operasional.plotting*') ? 'active' : '' }}" href="{{ route('admin.operasional.plotting') }}">
        <i class="fas fa-user-tag me-2" style="width: 20px;"></i> Plotting Konsultan
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.operasional.sidang*') ? 'active' : '' }}" href="{{ route('admin.operasional.sidang.index') }}">
        <i class="fas fa-gavel me-2" style="width: 20px;"></i> Sidang Fatwa
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.operasional.sertifikat*') ? 'active' : '' }}" href="{{ route('admin.operasional.sertifikat.index') }}">
        <i class="fas fa-certificate me-2" style="width: 20px;"></i> Penerbitan Sertifikat
    </a>
</li>

{{-- Grup Data Master --}}
<li class="px-3 mt-3 mb-1 opacity-50 menu-header text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 0.05em;">
    Data Master
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.master.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
        <i class="fas fa-users me-2" style="width: 20px;"></i> Manajemen User
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.master.paket*') ? 'active' : '' }}" href="{{ route('admin.paket.index') }}">
        <i class="fas fa-tags me-2" style="width: 20px;"></i> Manajemen Paket Harga
    </a>
</li>
