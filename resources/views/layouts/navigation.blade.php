<nav id="sidebar" class="shadow-sm">
    <div class="sidebar-header d-flex align-items-center justify-content-center">
        <div class="logo-wrapper d-flex align-items-center">
            <div class="logo-icon me-2 d-flex align-items-center justify-content-center">
                <i class="text-white fas fa-leaf small"></i>
            </div>
            <h4 class="mb-0">SIJAS<span>PENLAL</span></h4>
        </div>
    </div>

    <div class="sidebar-content">
        <ul class="list-unstyled components">
            @if(Auth::user()->role === 'admin')
                @include('layouts.partials.nav-admin')
            @elseif(Auth::user()->role === 'konsultan')
                @include('layouts.partials.nav-konsultan')
            @elseif(Auth::user()->role === 'keuangan')
                @include('layouts.partials.nav-keuangan')
            @elseif(Auth::user()->role === 'klien')
                @include('layouts.partials.nav-klien')
            @endif
        </ul>

        <div class="p-3 mt-4 sidebar-footer">
            <div class="p-3 border-0 card bg-light rounded-4">
                <p class="mb-0 text-center small text-muted" style="font-size: 0.7rem;">
                    <i class="fas fa-shield-halal text-emerald me-1"></i>
                    Certified Halal System <br>
                    <strong>Version 2.0</strong>
                </p>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Styling Tambahan khusus Sidebar Wrapper */
    #sidebar .logo-wrapper h4 {
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: -0.05em;
        color: var(--deep-forest);
    }

    #sidebar .logo-wrapper h4 span {
        color: var(--primary-emerald);
        opacity: 0.8;
    }

    .logo-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary-emerald), var(--deep-forest));
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.2);
    }

    /* Memastikan sidebar content memiliki scroll yang rapi jika menu terlalu panjang */
    .sidebar-content {
        height: calc(100vh - 110px);
        overflow-y: auto;
        padding-bottom: 20px;
    }

    .sidebar-content::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: transparent;
        border-radius: 10px;
    }

    #sidebar:hover .sidebar-content::-webkit-scrollbar-thumb {
        background: #e2e8f0;
    }

    /* Transisi Halus untuk menu saat di-include */
    .nav-item {
        animation: fadeInSide 0.4s ease forwards;
    }

    @keyframes fadeInSide {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>
