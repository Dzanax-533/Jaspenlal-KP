<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Konsultan Halal Indonesia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --khi-deep: #064e3b;
            --khi-olive: #84a474;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8faf9;
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 2rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 480px;
            border: 1px solid #f0f0f0;
        }

        .ui-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--khi-deep);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ui-input {
            width: 100%;
            padding: 12px 16px;
            background-color: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .ui-input:focus {
            outline: none;
            border-color: var(--khi-olive);
            box-shadow: 0 0 0 4px rgba(132, 164, 116, 0.15);
        }

        .btn-khi-primary {
            width: 100%;
            padding: 12px;
            background-color: var(--khi-deep);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-khi-primary:hover {
            background-color: #043629;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(6, 78, 59, 0.2);
        }

        .ui-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }

        .logo-img {
            height: 60px;
            margin-bottom: 1.5rem;
        }

        a {
            color: var(--khi-olive);
            text-decoration: none;
            font-weight: 700;
        }

        a:hover {
            color: var(--khi-deep);
        }
    </style>
</head>
<body>

<div class="container d-flex flex-column align-items-center justify-content-center">
    <div class="auth-card">
        {{-- LOGO KHI --}}
        <div class="text-center">
            <a href="/">
                <img src="{{ asset('img/logo-khi.png') }}" alt="KHI Logo" class="logo-img">
            </a>
            <h4 class="fw-bold text-dark tracking-tight mb-1">Daftar Akun Baru</h4>
            <p class="text-muted small mb-4">Mulai langkah sertifikasi halal Anda bersama kami.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="ui-label">Nama Lengkap</label>
                <input type="text" name="name" class="ui-input" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                @if($errors->has('name'))
                    <div class="ui-error">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="ui-label">Username</label>
                    <input type="text" name="username" class="ui-input" placeholder="Username" value="{{ old('username') }}" required>
                    @if($errors->has('username'))
                        <div class="ui-error">{{ $errors->first('username') }}</div>
                    @endif
                </div>
                <div class="col-6">
                    <label class="ui-label">No. WhatsApp</label>
                    <input type="text" name="no_telepon" class="ui-input" placeholder="WhatsApp" value="{{ old('no_telepon') }}" required>
                    @if($errors->has('no_telepon'))
                        <div class="ui-error">{{ $errors->first('no_telepon') }}</div>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="ui-label">Email</label>
                <input type="email" name="email" class="ui-input" placeholder="Email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="ui-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="mb-4">
                <label class="ui-label">Kata Sandi</label>
                <input type="password" name="password" class="ui-input mb-2" placeholder="Minimal 8 karakter" required>
                <input type="password" name="password_confirmation" class="ui-input" placeholder="Ulangi kata sandi" required>
                @if($errors->has('password'))
                    <div class="ui-error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <button type="submit" class="btn-khi-primary">
                Buat Akun Sekarang
            </button>

            <div class="text-center mt-4">
                <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
            </div>
        </form>
    </div>

    <footer class="mt-4 text-center">
        <p class="text-muted" style="font-size: 10px; letter-spacing: 1px; text-transform: uppercase;">
            © 2026 KHI — KONSULTAN HALAL INDONESIA
        </p>
    </footer>
</div>

</body>
</html>
