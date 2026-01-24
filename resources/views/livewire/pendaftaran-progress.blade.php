<div wire:poll.3s> {{-- INI RAHASIANYA: Komponen ini akan refresh otomatis tiap 3 detik --}}
    <div class="bg-white p-10 shadow-xl rounded-2xl border border-gray-100">
        <div class="mb-10 text-center">
            <h3 class="text-2xl font-black text-indigo-900 uppercase tracking-tighter">Tracking No. Reg</h3>
            <p class="text-indigo-600 font-mono font-bold">{{ $pendaftaran->no_pendaftaran }}</p>
            <div class="mt-2 flex justify-center items-center gap-2">
                <span class="text-[10px] text-green-500 font-bold uppercase tracking-widest animate-pulse">● Live Tracking Aktif</span>
            </div>
        </div>

        <div class="relative">
            <div class="absolute left-6 top-0 h-full w-0.5 bg-gray-100"></div>

            @php
                $steps = [
                    1 => ['judul' => 'Pendaftaran', 'desc' => 'Pengajuan awal dan penerbitan invoice.'],
                    2 => ['judul' => 'Pembayaran DP', 'desc' => 'Verifikasi pembayaran uang muka (60%).'],
                    3 => ['judul' => 'Melengkapi Dokumen', 'desc' => 'Unggah NIB, KTP, dan Komitmen Halal.'],
                    4 => ['judul' => 'Input Daftar Bahan', 'desc' => 'Pendataan semua bahan baku produk.'],
                    5 => ['judul' => 'Audit Lapangan', 'desc' => 'Pemeriksaan lokasi oleh Auditor.'],
                    6 => ['judul' => 'Sidang Fatwa', 'desc' => 'Rapat penetapan status halal oleh MUI.'],
                    7 => ['judul' => 'Sertifikat Terbit', 'desc' => 'Sertifikat Halal selesai dan siap diunduh.'],
                ];
            @endphp

            @foreach($steps as $level => $step)
                <div class="mb-10 flex items-start relative">
                    <div class="z-10 flex items-center justify-center w-12 h-12 rounded-full border-4 border-white shadow-md transition-all duration-500
                        {{ $pendaftaran->progress_level > $level ? 'bg-green-500 text-white' : ($pendaftaran->progress_level == $level ? 'bg-indigo-600 text-white animate-bounce' : 'bg-gray-100 text-gray-400') }}">
                        @if($pendaftaran->progress_level > $level)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <span class="font-bold text-sm">{{ $level }}</span>
                        @endif
                    </div>

                    <div class="ml-8 flex-1">
                        <h4 class="font-black text-sm uppercase tracking-widest {{ $pendaftaran->progress_level == $level ? 'text-indigo-600' : ($pendaftaran->progress_level > $level ? 'text-green-600' : 'text-gray-300') }}">
                            {{ $step['judul'] }}
                        </h4>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
