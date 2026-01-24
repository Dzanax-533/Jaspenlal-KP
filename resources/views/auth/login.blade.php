<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Konsultan Halal Indonesia</title>

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
            max-width: 440px;
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

        .form-check-input:checked {
            background-color: var(--khi-deep);
            border-color: var(--khi-deep);
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
            <h4 class="fw-bold text-dark tracking-tight mb-1">Selamat Datang</h4>
            <p class="text-muted small mb-4">Masuk ke akun Anda untuk memantau progres.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success border-0 rounded-3 small mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="ui-label">Email</label>
                <input type="email" name="email" class="ui-input" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @if($errors->has('email'))
                    <div class="ui-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="ui-label">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small" style="font-size: 11px; margin-bottom: 8px;">Lupa Sandi?</a>
                    @endif
                </div>
                <input type="password" name="password" class="ui-input" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                @if($errors->has('password'))
                    <div class="ui-error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="mb-4 form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Ingat perangkat ini</label>
            </div>

            <button type="submit" class="btn-khi-primary">
                Masuk ke Dashboard
            </button>

            <div class="text-center mt-4">
                <p class="small text-muted">Belum terdaftar? <a href="{{ route('register') }}">Buat Akun KHI</a></p>
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
