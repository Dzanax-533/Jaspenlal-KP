<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KHI - Konsultan Halal Indonesia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --khi-deep: #064e3b; /* Hijau Tua Hutan */
            --khi-olive: #84a474; /* Hijau Muda Logo */
            --khi-light: #f8faf9;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: white; color: #1a1a1a; }

        .bg-khi-deep { background-color: var(--khi-deep); }
        .text-khi-deep { color: var(--khi-deep); }
        .text-khi-olive { color: var(--khi-olive); }

        .btn-khi-primary {
            background-color: var(--khi-deep);
            color: white;
            transition: all 0.3s ease;
            border: 1px solid var(--khi-deep);
        }
        .btn-khi-primary:hover {
            background-color: transparent;
            color: var(--khi-deep);
        }

        .btn-khi-outline {
            border: 2px solid var(--khi-deep);
            color: var(--khi-deep);
            transition: all 0.3s ease;
        }
        .btn-khi-outline:hover {
            background-color: var(--khi-deep);
            color: white;
        }

        .card-premium {
            border: 1px solid #e5e7eb;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-premium:hover {
            border-color: var(--khi-olive);
            transform: translateY(-12px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .hero-gradient {
            background: linear-gradient(180deg, #f0f4f1 0%, #ffffff 100%);
        }
    </style>
</head>
<body class="antialiased">

    <nav class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md">
        <div class="flex items-center justify-between h-20 px-6 mx-auto max-w-7xl">
            <a href="/">
                <img src="{{ asset('img/logo-khi.png') }}" alt="Konsultan Halal Indonesia" class="h-12 lg:h-14">
            </a>

            <div class="items-center hidden gap-10 md:flex">
                <a href="#tentang" class="text-sm font-semibold transition hover:text-khi-olive">Tentang Kami</a>
                <a href="#paket" class="text-sm font-semibold transition hover:text-khi-olive">Paket Layanan</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-khi-primary px-6 py-2.5 rounded-full text-sm font-bold shadow-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-khi-deep">Log in</a>
                    <a href="{{ route('register') }}" class="btn-khi-primary px-7 py-2.5 rounded-full text-sm font-bold shadow-md">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="px-6 pt-16 pb-24 hero-gradient">
        <div class="flex flex-col items-center gap-16 mx-auto max-w-7xl lg:flex-row">
            <div class="lg:w-1/2">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-8 h-px bg-khi-olive"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-khi-olive">Trust & Integrity</span>
                </div>
                <h1 class="mb-8 text-5xl font-extrabold leading-tight lg:text-7xl text-khi-deep">
                    Partner Strategis Sertifikasi <span class="text-khi-olive">Halal</span> Anda.
                </h1>
                <p class="mb-10 text-lg leading-relaxed text-gray-500 lg:text-xl">
                    Kami hadir untuk memastikan setiap langkah pengurusan sertifikat halal produk Anda berjalan sesuai regulasi BPJPH dengan pendampingan ahli dan sistem digital yang transparan.
                </p>
                <div class="flex flex-col gap-5 sm:flex-row">
                    <a href="{{ route('register') }}" class="px-10 py-4 font-bold text-center rounded-full shadow-lg btn-khi-primary">
                        Mulai Konsultasi
                    </a>
                    <a href="#paket" class="px-10 py-4 font-bold text-center rounded-full btn-khi-outline">
                        Lihat Pricelist
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2">
                <div class="relative">
                    <div class="absolute w-24 h-24 rounded-full -top-4 -left-4 bg-khi-olive/20 blur-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?q=80&w=1000&auto=format&fit=crop" class="rounded-[2.5rem] shadow-2xl grayscale hover:grayscale-0 transition duration-700" alt="Halal Quality">
                    <div class="absolute p-6 bg-white border shadow-xl -bottom-6 -right-6 rounded-2xl border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-12 h-12 text-white rounded-full bg-khi-olive">
                                <i class="fas fa-shield-halal fa-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-khi-deep">100% Sesuai Regulasi</h4>
                                <p class="text-xs text-gray-400">Standar BPJPH RI</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="px-6 py-24 bg-white">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-3xl mx-auto mb-20 text-center">
                <h2 class="mb-5 text-4xl font-bold text-khi-deep">Pilihan Paket Pendampingan</h2>
                <p class="text-gray-500">Transparansi biaya adalah komitmen kami. Pilih paket yang sesuai dengan volume menu dan skala bisnis Anda.</p>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="card-premium p-10 bg-white rounded-[2rem] flex flex-col">
                    <h3 class="mb-1 text-xl font-bold">Silver Plan</h3>
                    <p class="mb-6 text-xs font-semibold tracking-wider uppercase text-khi-olive">Usaha Mikro</p>
                    <div class="flex items-baseline gap-1 mb-8">
                        <span class="text-4xl font-extrabold text-khi-deep">Rp 2.500.000</span>
                    </div>
                    <ul class="flex-grow mb-10 space-y-4 text-sm text-gray-500">
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Membantu Pendaftaran SiHalal</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Input Data Sistem</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Dan Review Bahan</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-4 font-bold text-center btn-khi-outline rounded-xl">Pilih Paket</a>
                </div>

                <div class="card-premium p-10 bg-khi-deep rounded-[2rem] flex flex-col text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-khi-olive text-khi-deep text-[10px] font-black px-6 py-2 rounded-bl-2xl">REKOMENDASI</div>
                    <h3 class="mb-1 text-xl font-bold">Gold Plan</h3>
                    <p class="mb-6 text-xs font-semibold tracking-wider uppercase text-khi-olive">Usaha Kecil & Menengah</p>
                    <div class="flex items-baseline gap-1 mb-8 text-white">
                        <span class="text-4xl font-extrabold">Rp 10.000.000</span>
                    </div>
                    <ul class="flex-grow mb-10 space-y-4 text-sm text-gray-300">
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Maksimal 100 Item Produk</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Pendampingan Dokumen PPH</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Prioritas Audit Lapangan</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Bantuan Layout Fasilitas</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-4 font-bold text-center transition bg-white text-khi-deep rounded-xl hover:bg-khi-olive">Pilih Paket</a>
                </div>

                <div class="card-premium p-10 bg-white rounded-[2rem] flex flex-col">
                    <h3 class="mb-1 text-xl font-bold">Platinum Plan</h3>
                    <p class="mb-6 text-xs font-semibold tracking-wider uppercase text-khi-olive">Perusahaan & Manufaktur</p>
                    <div class="flex items-baseline gap-1 mb-8">
                        <span class="text-4xl font-extrabold text-khi-deep">Rp 22.000.000</span>
                    </div>
                    <ul class="flex-grow mb-10 space-y-4 text-sm text-gray-500">
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Menu Tanpa Batas</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Full Service Manajemen SJPH</li>
                        <li class="flex items-center gap-3"><i class="fas fa-circle-check text-khi-olive"></i> Kunjungan On-Site Berkala</li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-4 font-bold text-center btn-khi-outline rounded-xl">Pilih Paket</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="px-6 pt-20 pb-10 text-white bg-khi-deep">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col items-start justify-between gap-12 mb-20 md:flex-row">
                <div class="max-w-xs">
                    <img src="{{ asset('img/logo-khi.png') }}" alt="Logo KHI" class="h-16 mb-6 brightness-0 invert">
                    <p class="text-sm leading-relaxed text-gray-400">Konsultan Halal Indonesia berkomitmen meningkatkan daya saing UMKM melalui standarisasi Halal yang kredibel.</p>
                </div>
                <div class="grid grid-cols-2 gap-16">
                    <div>
                        <h5 class="mb-6 font-bold">Layanan</h5>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li><a href="#" class="transition hover:text-white">Self Declare</a></li>
                            <li><a href="#" class="transition hover:text-white">Reguler Audit</a></li>
                            <li><a href="#" class="transition hover:text-white">Pelatihan Halal</a></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="mb-6 font-bold">Hubungi Kami</h5>
                        <ul class="space-y-4 text-sm text-gray-400">
                            <li>info@khi-halal.id</li>
                            <li>(021) 1234-5678</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between gap-6 pt-10 border-t border-white/5 md:flex-row">
                <p class="text-xs tracking-widest text-gray-500 uppercase">© 2026 Konsultan Halal Indonesia. Semua Hak Dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-500 transition hover:text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-gray-500 transition hover:text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
