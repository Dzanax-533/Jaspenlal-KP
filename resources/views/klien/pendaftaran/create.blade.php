@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="row justify-content-center">
        <div class="col-xl-11">

            {{-- Indikator Langkah --}}
            <div class="mb-4 row g-3">
                @php
                    $steps = [
                        ['icon' => 'layer-group', 'title' => 'Pilih Paket', 'desc' => 'Otomatis Sesuai Skala'],
                        ['icon' => 'calculator', 'title' => 'Detail Menu', 'desc' => 'Jumlah produk & gerai'],
                        ['icon' => 'dollar-sign', 'title' => 'Aktivasi', 'desc' => 'Lanjut ke pembayaran DP']
                    ];
                @endphp
                @foreach($steps as $key => $s)
                <div class="col-md-4">
                    <div class="bg-white border-0 shadow-sm card rounded-4 h-100 transition-hover {{ $key == 0 ? 'border-start border-emerald border-4' : '' }}">
                        <div class="p-3 card-body d-flex align-items-center">
                            <div class="shadow-sm icon-box {{ $key == 0 ? 'bg-emerald text-white' : 'bg-soft-emerald text-emerald' }} me-3 rounded-3">
                                <i class="fas fa-{{ $s['icon'] }}"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-deep-forest" style="font-size: 0.9rem;">{{ $s['title'] }}</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">{{ $s['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="overflow-hidden border-0 shadow-lg card rounded-4">
                <div class="px-4 py-4 bg-white card-header border-bottom px-md-5 bg-light-gradient">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-800 text-deep-forest">Form Pendaftaran Pendampingan</h5>
                            <p class="mb-0 text-muted small">Pendaftaran otomatis untuk skala usaha <strong>{{ ucfirst($skalaUsaha) }}</strong>.</p>
                        </div>
                        <span class="px-3 py-2 badge bg-soft-emerald text-emerald rounded-pill small fw-bold">
                            <i class="fas fa-lock me-1"></i> PAKET TERKUNCI SISTEM
                        </span>
                    </div>
                </div>

                <div class="p-4 card-body p-md-5">
                    <form action="{{ route('klien.pendaftaran.store') }}" method="POST">
                        @csrf
                        <div class="row g-5">
                            {{-- Sisi Kiri: Input Data --}}
                            <div class="col-lg-7">
                                <div class="mb-4 group-input-container">
                                    <label class="label-muted-caps">PAKET LAYANAN (Ditetapkan Sistem)</label>

                                    @php
                                        $userSkala = strtolower($skalaUsaha ?? 'kecil');
                                        if($userSkala == 'mikro') $userSkala = 'kecil';

                                        $paketTerpilih = $pakets->first(function($p) use ($userSkala) {
                                            $nama = strtolower($p->nama_paket);
                                            if($userSkala == 'kecil') return str_contains($nama, 'silver');
                                            if($userSkala == 'menengah') return str_contains($nama, 'gold');
                                            if($userSkala == 'besar') return str_contains($nama, 'platinum');
                                            return false;
                                        });

                                        $paketTerpilih = $paketTerpilih ?? $pakets->first();
                                    @endphp

                                    <div class="input-group custom-group shadow-sm">
                                        <span class="bg-light input-group-text border-end-0">
                                            <i class="fas fa-shield-check text-emerald"></i>
                                        </span>
                                        <input type="text" class="bg-light form-control border-start-0 fw-bold text-deep-forest"
                                            value="{{ $paketTerpilih->nama_paket }}"
                                            style="height: 60px; cursor: not-allowed;" readonly>
                                    </div>

                                    <input type="hidden" name="paket_id" id="paket_id_hidden"
                                        value="{{ $paketTerpilih->id }}"
                                        data-harga="{{ $paketTerpilih->harga }}"
                                        data-nama="{{ $paketTerpilih->nama_paket }}">

                                    <div class="p-3 mt-3 border rounded-3 bg-soft-emerald border-emerald border-opacity-10 d-flex align-items-center">
                                        <i class="fas fa-info-circle text-emerald me-3 fs-4"></i>
                                        <p class="mb-0 text-deep-forest x-small">
                                            Sistem mendeteksi skala <strong>{{ strtoupper($userSkala) }}</strong>. Paket <strong>{{ $paketTerpilih->nama_paket }}</strong> telah dikunci otomatis sesuai regulasi.
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 row">
                                    <div class="mb-4 col-md-6">
                                        <label class="label-muted-caps">TOTAL MENU / PRODUK</label>
                                        <div class="input-group custom-group shadow-sm">
                                            <span class="bg-white input-group-text border-end-0"><i class="fas fa-utensils text-emerald"></i></span>
                                            <input type="number" name="total_menu" class="form-control border-start-0 fw-bold"
                                                   placeholder="Contoh: 10" value="{{ old('total_menu', 1) }}" style="height: 60px;" required>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <label class="label-muted-caps">TOTAL OUTLET / GERAI</label>
                                        <div class="input-group custom-group shadow-sm">
                                            <span class="bg-white input-group-text border-end-0"><i class="fas fa-store text-emerald"></i></span>
                                            <input type="number" name="total_outlet" class="form-control border-start-0 fw-bold"
                                                   placeholder="Contoh: 1" value="{{ old('total_outlet', 1) }}" style="height: 60px;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Sisi Kanan: Summary Card --}}
                            <div class="col-lg-5">
                                <div class="p-4 border bg-light rounded-4 h-100 d-flex flex-column">
                                    <div class="mb-auto">
                                        <label class="mb-3 text-center label-muted-caps d-block">ESTIMASI BIAYA KONTRAK</label>

                                        <div class="p-4 mb-4 bg-white border border-emerald shadow-sm rounded-4">
                                            <small class="text-muted d-block mb-3 text-center label-muted-caps">Rincian Biaya</small>

                                            <div class="mb-2 d-flex justify-content-between x-small">
                                                <span class="text-muted">Harga Dasar Paket:</span>
                                                <span class="fw-bold" id="detail-base-price">Rp 0</span>
                                            </div>
                                            <div class="mb-2 d-flex justify-content-between x-small" id="row-menu-extra" style="display: none !important;">
                                                <span class="text-muted">Tambahan Menu:</span>
                                                <span class="fw-bold text-danger" id="detail-menu-price">+ Rp 0</span>
                                            </div>
                                            <div class="mb-2 d-flex justify-content-between x-small" id="row-outlet-extra" style="display: none !important;">
                                                <span class="text-muted">Tambahan Outlet:</span>
                                                <span class="fw-bold text-danger" id="detail-outlet-price">+ Rp 0</span>
                                            </div>

                                            <hr class="my-3 opacity-10">

                                            <div class="text-center">
                                                <small class="text-muted d-block mb-1">Total Biaya (Lunas)</small>
                                                <h3 class="fw-800 text-emerald mb-0" id="live-total">Rp 0</h3>
                                            </div>

                                            <hr class="my-3 opacity-10">

                                            <div class="d-flex justify-content-between x-small fw-bold p-2 bg-soft-emerald rounded-3">
                                                <span class="text-emerald">DP 60% (Aktivasi):</span>
                                                <span class="text-emerald" id="live-dp">Rp 0</span>
                                            </div>
                                        </div>

                                        <div class="mb-4 border-0 shadow-sm card rounded-4 select-card transition-hover">
                                            <div class="p-3 card-body">
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input custom-check me-3" type="checkbox" name="luar_jabodetabek" id="luar">
                                                    <label class="cursor-pointer form-check-label flex-grow-1" for="luar">
                                                        <span class="fw-bold d-block text-deep-forest small">Luar Jabodetabek?</span>
                                                        <span class="text-muted x-small">Audit fisik di luar JABODETABEK memerlukan biaya akomodasi tambahan.</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 mt-4 border-top">
                                        <button type="submit" class="py-3 btn btn-emerald w-100 fw-bold rounded-3 shadow-emerald btn-lg">
                                            LANJUT KE INVOICE <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --emerald: #10b981; --deep-forest: #1a2e2a; }
    .fw-800 { font-weight: 800; }
    .text-deep-forest { color: var(--deep-forest); }
    .text-emerald { color: var(--emerald) !important; }
    .bg-emerald { background-color: var(--emerald) !important; }
    .bg-soft-emerald { background-color: rgba(16, 185, 129, 0.08) !important; }
    .label-muted-caps { font-size: 0.75rem; font-weight: 700; color: #94a3b8; letter-spacing: 0.05em; text-transform: uppercase; display: block; margin-bottom: 0.8rem; }
    .btn-emerald { background-color: var(--emerald); color: white; border: none; }
    .btn-emerald:hover { background-color: #059669; color: white; }
    .shadow-emerald { box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4); }
    .icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .custom-check { width: 22px; height: 22px; cursor: pointer; }
    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-4px); }
    .x-small { font-size: 0.75rem; line-height: 1.5; }
    .select-card { cursor: pointer; border: 2px solid transparent; }
    .select-card:hover { border-color: var(--emerald); }
    input[readonly] { background-color: #f8f9fa !important; }
</style>

<script>
    const inputMenu = document.querySelector('input[name="total_menu"]');
    const inputOutlet = document.querySelector('input[name="total_outlet"]');
    const hiddenPaket = document.getElementById('paket_id_hidden');

    function calculate() {
        if (!hiddenPaket) return;

        const namaPaket = hiddenPaket.getAttribute('data-nama').toLowerCase();

        let hargaBase = 0;
        let menuRate = 500000;

        if (namaPaket.includes('kecil') || namaPaket.includes('silver')) {
            hargaBase = 2500000;
            menuRate = 500000;
        } else if (namaPaket.includes('menengah') || namaPaket.includes('gold')) {
            hargaBase = 10000000;
            menuRate = 1000000;
        } else if (namaPaket.includes('besar') || namaPaket.includes('platinum')) {
            hargaBase = 22000000;
            menuRate = 1500000;
        }

        const menu = parseInt(inputMenu.value) || 0;
        const outlet = parseInt(inputOutlet.value) || 0;

        // Hitung Tambahan Menu (> 50 item, per 30 item)
        let biayaMenuExtra = 0;
        if (menu > 50) {
            biayaMenuExtra = Math.ceil((menu - 50) / 30) * menuRate;
            document.getElementById('row-menu-extra').style.setProperty('display', 'flex', 'important');
            document.getElementById('detail-menu-price').innerText = '+ Rp ' + biayaMenuExtra.toLocaleString('id-ID');
        } else {
            document.getElementById('row-menu-extra').style.setProperty('display', 'none', 'important');
        }

        // Hitung Tambahan Outlet (1.5jt per outlet tambahan)
        let biayaOutletExtra = 0;
        if (outlet > 1) {
            biayaOutletExtra = (outlet - 1) * 1500000;
            document.getElementById('row-outlet-extra').style.setProperty('display', 'flex', 'important');
            document.getElementById('detail-outlet-price').innerText = '+ Rp ' + biayaOutletExtra.toLocaleString('id-ID');
        } else {
            document.getElementById('row-outlet-extra').style.setProperty('display', 'none', 'important');
        }

        const total = hargaBase + biayaMenuExtra + biayaOutletExtra;
        const dp = total * 0.6;

        // Update UI
        document.getElementById('detail-base-price').innerText = 'Rp ' + hargaBase.toLocaleString('id-ID');
        document.getElementById('live-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('live-dp').innerText = 'Rp ' + dp.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', calculate);
    inputMenu.addEventListener('input', calculate);
    inputOutlet.addEventListener('input', calculate);
</script>
@endsection
