@php
    $steps = [
        1  => ['icon' => 'box',             'label' => 'Paket'],
        2  => ['icon' => 'wallet',          'label' => 'Bayar DP'],
        3  => ['icon' => 'user-check',      'label' => 'Verifikasi'],
        4  => ['icon' => 'user-shield',     'label' => 'Plotting'],
        5  => ['icon' => 'file-upload',     'label' => 'Dokumen'],
        6  => ['icon' => 'flask',           'label' => 'Bahan'],
        7  => ['icon' => 'clipboard-check', 'label' => 'Audit'],
        8  => ['icon' => 'gavel',           'label' => 'Sidang'],
        9  => ['icon' => 'money-bill-wave', 'label' => 'Lunas'],
        10 => ['icon' => 'award',           'label' => 'Selesai']
    ];
    // Pastikan level default adalah 1 jika data tidak ditemukan
    $currentLevel = $pendaftaran->progress_level ?? 1;
@endphp

<div class="timeline-container-compact py-3">
    <div class="timeline-track-compact">
        @foreach($steps as $level => $step)
            {{-- Item Logic: Is Complete (Sudah lewat), Is Current (Sedang jalan) --}}
            <div class="t-item {{ $currentLevel > $level ? 'is-complete' : '' }} {{ $currentLevel == $level ? 'is-current' : '' }}">
                <div class="t-node-wrapper">
                    <div class="t-icon-box shadow-sm">
                        <i class="fas fa-{{ $step['icon'] }}"></i>
                        {{-- Centang badge jika level sudah terlewati --}}
                        @if($currentLevel > $level)
                            <div class="t-check-badge"><i class="fas fa-check"></i></div>
                        @endif
                    </div>
                    <div class="t-text-box">
                        <p class="t-label mb-0">{{ $step['label'] }}</p>
                        <span class="t-sub">LVL {{ $level }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .timeline-container-compact {
        width: 100%;
        overflow-x: auto;
        padding: 15px 10px;
        scrollbar-width: none; /* Firefox */
    }
    .timeline-container-compact::-webkit-scrollbar { display: none; } /* Chrome/Safari */

    .timeline-track-compact {
        display: flex;
        justify-content: space-between;
        position: relative;
        /* Dinaikkan ke 850px agar 10 node tidak terlalu berhimpitan di layar kecil */
        min-width: 850px;
    }

    /* Garis Penghubung Dasar (Abu-abu) */
    .t-item:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 20px;
        left: calc(50% + 20px);
        width: calc(100% - 40px);
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }

    /* Garis Penghubung SELESAI (Hijau) */
    .t-item.is-complete:not(:last-child)::after {
        background: #10b981;
    }

    .t-item {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .t-node-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .t-icon-box {
        width: 40px;
        height: 40px;
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        position: relative;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    /* WARNA SELESAI (HIJAU) */
    .is-complete .t-icon-box {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }
    .is-complete .t-label { color: #10b981; }

    /* WARNA SEDANG JALAN (BIRU) */
    .is-current .t-icon-box {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
        animation: pulse-compact 2s infinite;
    }
    .is-current .t-label {
        color: #3b82f6;
        font-weight: 800;
        transform: scale(1.1);
    }

    .t-check-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #059669;
        color: #fff;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    .t-text-box {
        text-align: center;
        margin-top: 10px;
    }

    .t-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #475569;
        white-space: nowrap;
        transition: 0.3s;
    }

    .t-sub {
        font-size: 0.55rem;
        font-weight: 800;
        color: #94a3b8;
        display: block;
        margin-top: 2px;
    }

    @keyframes pulse-compact {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
