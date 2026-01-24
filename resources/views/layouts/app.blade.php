<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JASPENLAL</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-emerald: #10b981;    /* Emerald Utama */
            --deep-forest: #064e3b;       /* Untuk teks logo & elemen kontras */
            --sage-light: #f0fdf4;        /* Background hover/active */
            --sidebar-bg: #ffffff;        /* Sidebar Putih */
            --text-main: #1f2937;         /* Abu-abu tua profesional */
            --text-muted: #6b7280;        /* Abu-abu soft */
            --bg-body: #f8fafc;           /* Background Body */
            --border-color: #f1f5f9;      /* Border halus */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
            letter-spacing: -0.01em;
        }

        /* --- WRAPPER STRUCTURE --- */
        .wrapper {
            display: flex;
            align-items: stretch;
            min-height: 100vh;
        }

        /* --- SIDEBAR STYLE (ELEGANT MINIMALIST) --- */
        #sidebar {
            min-width: 280px;
            max-width: 280px;
            background: var(--sidebar-bg);
            color: var(--text-main);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1030;
            border-right: 1px solid var(--border-color);
            box-shadow: 10px 0 15px -10px rgba(0,0,0,0.04);
            position: relative;
        }

        #sidebar.active {
            margin-left: -280px;
        }

        #sidebar .sidebar-header {
            padding: 40px 30px;
            background: var(--sidebar-bg);
        }

        #sidebar .sidebar-header h4 {
            font-weight: 800;
            color: var(--deep-forest);
            margin: 0;
            font-size: 1.35rem;
            letter-spacing: -0.04em;
            text-transform: uppercase;
        }

        #sidebar .sidebar-header span {
            color: var(--primary-emerald);
        }

        #sidebar ul.components {
            padding: 10px 0;
        }

        #sidebar .menu-header {
            padding: 25px 30px 10px;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--text-muted);
            letter-spacing: 0.15em;
        }

        #sidebar ul li a {
            padding: 12px 25px;
            margin: 4px 20px;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            color: var(--text-main);
            text-decoration: none;
            transition: 0.25s all ease;
            border-radius: 12px;
            font-weight: 500;
        }

        #sidebar ul li a i {
            width: 32px;
            font-size: 1.1rem;
            color: var(--text-muted);
            transition: 0.2s;
        }

        #sidebar ul li a:hover {
            color: var(--primary-emerald);
            background: var(--sage-light);
        }

        #sidebar ul li a:hover i {
            color: var(--primary-emerald);
        }

        #sidebar ul li.active > a {
            color: #ffffff;
            background: var(--primary-emerald);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
            font-weight: 600;
        }

        #sidebar ul li.active > a i {
            color: #ffffff;
        }

        /* --- CONTENT STYLE --- */
        #content {
            width: 100%;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        /* --- NAVBAR TOP (GLASSMORPHISM) --- */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
            z-index: 1020;
        }

        /* --- CARDS & ALERTS (PREMIUM FINISH) --- */
        .card {
            border: 1px solid rgba(0,0,0,0.03);
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.02), 0 8px 10px -6px rgba(0,0,0,0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.03), 0 10px 10px -5px rgba(0,0,0,0.02);
        }

        .alert {
            border: none;
            border-radius: 16px;
            padding: 1.1rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            background: white;
            border-left: 5px solid transparent;
        }

        .alert-success { border-left-color: var(--primary-emerald); color: var(--deep-forest); }
        .alert-warning { border-left-color: #f59e0b; }

        /* --- UTILS --- */
        .avatar-circle {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--primary-emerald);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
        }

        .bg-soft-emerald {
            background-color: var(--sage-light);
            color: var(--primary-emerald);
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 10px;
        }

        .btn-primary {
            background: var(--primary-emerald);
            border: none;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(16, 185, 129, 0.2);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        @media (max-width: 768px) {
            #sidebar { margin-left: -280px; }
            #sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        @include('layouts.navigation')

        <div id="content">
            @include('layouts.partials.navbar-top')

            <div class="p-4 container-fluid">
                @if(session('success'))
                    <div class="mb-4 border-0 alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fs-5 text-emerald"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-4 border-0 alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fs-5 text-warning"></i>
                            <div>{{ session('warning') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Sidebar Toggle Logic
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            // Active State Handler
            var currentUrl = window.location.href;
            $('#sidebar ul li a').each(function() {
                if (this.href === currentUrl) {
                    $(this).closest('li').addClass('active');
                }
            });
        });
    </script>
</body>
</html>
