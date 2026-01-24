<x-app-layout>
    <x-slot name="header">Laporan Keuangan & Rekapitulasi</x-slot>

    <div class="py-8">
        <div class="grid grid-cols-1 gap-8 mb-8 md:grid-cols-2">
            @foreach($rekap as $data)
            <div class="flex items-center justify-between p-8 bg-white shadow-xl modern-card shadow-slate-100 group">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Bulan ke-{{ $data->bulan }}</p>
                    <h4 class="text-2xl font-black text-slate-900">Rp{{ number_format($data->total_pendapatan, 0, ',', '.') }}</h4>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Total Klien</p>
                    <p class="text-2xl font-black text-slate-900">{{ $data->total_klien }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="relative p-10 overflow-hidden text-white modern-card bg-slate-900">
            <div class="relative z-10">
                <h3 class="mb-2 text-3xl italic font-black tracking-tighter uppercase">Ekspor Laporan</h3>
                <p class="mb-8 text-sm text-slate-400">Download rekapitulasi transaksi dalam format Excel untuk kebutuhan pembukuan.</p>
                <button class="px-8 py-4 bg-indigo-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:scale-105 transition-transform">
                    Download Report (.XLSX)
                </button>
            </div>
            <div class="absolute pointer-events-none -right-10 -bottom-10 text-white/5">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14h-2v-4H8v-2h4V7h2v4h4v2h-4v4z"/></svg>
            </div>
        </div>
    </div>
</x-app-layout>
