<nav class="navbar navbar-expand-lg navbar-light">
    <div class="px-4 container-fluid">
        <button type="button" id="sidebarCollapse" class="border-0 shadow-sm btn btn-white rounded-circle me-3">
            <i class="fas fa-bars" style="color: var(--primary-emerald);"></i>
        </button>

        <div class="d-none d-md-block">
            <h6 class="mb-0 fw-semibold text-dark" style="letter-spacing: -0.02em;">Sistem Jasa Pendampingan Sertifikasi Halal</h6>
            <small class="text-muted" style="font-size: 0.75rem;">PT Konsultan Halal Indonesia</small>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="me-3 text-end d-none d-sm-block">
                <span class="d-block fw-bold text-dark lh-1" style="font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                <span class="mt-1 badge bg-soft-emerald text-uppercase" style="font-size: 9px; letter-spacing: 0.1em;">
                    {{ Auth::user()->role }}
                </span>
            </div>

            <div class="shadow-sm avatar-circle">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>

            <div class="mx-3 vr opacity-10" style="height: 30px; background-color: var(--text-main);"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 py-1 btn btn-logout d-flex align-items-center">
                    <i class="fas fa-power-off me-2 small"></i>
                    <span class="d-none d-md-inline fw-semibold" style="font-size: 0.85rem;">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    /* Styling khusus Navbar agar sinkron dengan app.blade.php */
    .btn-white {
        background: #ffffff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s all ease;
    }

    .btn-white:hover {
        background: var(--sage-light);
        transform: rotate(90deg);
    }

    .btn-logout {
        color: #ef4444;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-logout:hover {
        background: #ef4444;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    /* Badge khusus role bertema emerald */
    .bg-soft-emerald {
        background-color: var(--sage-light);
        color: var(--primary-emerald);
    }

    /* Penyesuaian Avatar agar seragam dengan variabel app.blade.php */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-emerald), var(--deep-forest));
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        border: 2px solid #ffffff;
    }
</style>
