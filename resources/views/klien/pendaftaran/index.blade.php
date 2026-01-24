<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Sertifikasi Halal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-fit border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700 uppercase tracking-wider">Form Pengajuan Baru</h3>
                    <form action="{{ route('klien.pendaftaran.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="paket_id" value="Pilih Skala Usaha" />
                            <select name="paket_id" id="paket_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                                @foreach($pakets as $paket)
                                    <option value="{{ $paket->id }}">{{ $paket->nama_paket }} (Rp {{ number_format($paket->harga, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="total_menu" value="Total Menu" />
                            <x-text-input id="total_menu" name="total_menu" type="number" class="mt-1 block w-full text-sm" value="50" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="total_outlet" value="Total Outlet/Fasilitas" />
                            <x-text-input id="total_outlet" name="total_outlet" type="number" class="mt-1 block w-full text-sm" value="1" required />
                        </div>
                        <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700">{{ __('Kirim Pengajuan') }}</x-primary-button>
                    </form>
                </div>

                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-700 uppercase tracking-wider">Riwayat Pendaftaran</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-100 rounded-lg">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 font-bold">
                                <tr>
                                    <th class="px-4 py-3 border-b text-center">No. Reg</th>
                                    <th class="px-4 py-3 border-b">Paket</th>
                                    <th class="px-4 py-3 border-b">Biaya</th>
                                    <th class="px-4 py-3 border-b text-center">Status</th>
                                    <th class="px-4 py-3 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarans as $p)
                                <tr class="border-b hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 py-3 font-mono text-indigo-600 font-bold text-center text-xs tracking-tighter">
                                        {{ $p->no_pendaftaran }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-800 text-[11px]">{{ $p->paket->nama_paket }}</div>
                                        <div class="text-[9px] text-gray-400 italic">({{ $p->total_menu }} Menu, {{ $p->total_outlet }} Lokasi)</div>
                                    </td>
                                    <td class="px-4 py-3 font-black text-gray-700">
                                        {{ $p->total_biaya ? 'Rp '.number_format($p->total_biaya, 0, ',', '.') : '---' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $badgeColor = match($p->status) {
                                                'pending' => 'bg-gray-100 text-gray-600',
                                                'invoice' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                                'bayar_dp' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                                'proses' => 'bg-green-100 text-green-700 border border-green-200',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                            $latestPayment = $p->pembayarans()->latest()->first();
                                        @endphp
                                        <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase {{ $badgeColor }}">
                                            {{ $p->status }}
                                        </span>

                                        @if($latestPayment && $latestPayment->status_verifikasi == 'rejected' && $p->status == 'invoice')
                                            <div class="mt-2 text-[9px] text-red-600 bg-red-50 p-1 rounded border border-red-200 animate-pulse">
                                                <strong>Tolak:</strong> {{ $latestPayment->keterangan }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($p->status == 'invoice')
                                            <div class="flex flex-col gap-1">
                                                <a href="{{ route('klien.pendaftaran.invoice', $p->id) }}" class="text-[9px] bg-blue-600 text-white px-2 py-1.5 rounded font-black uppercase hover:bg-blue-700 transition shadow-sm">
                                                    Lihat Invoice
                                                </a>
                                                <a href="{{ route('klien.pendaftaran.bayar', $p->id) }}" class="text-[9px] bg-green-600 text-white px-2 py-1.5 rounded font-black uppercase hover:bg-green-700 transition shadow-sm">
                                                    Upload Bukti
                                                </a>
                                            </div>
                                        @elseif($p->status == 'bayar_dp')
                                            <div class="flex flex-col items-center">
                                                <span class="text-[10px] text-yellow-600 font-bold uppercase italic animate-pulse">Menunggu Cek</span>
                                                <span class="text-[8px] text-gray-400 font-medium">(Maks. 24 Jam)</span>
                                            </div>
                                        @elseif($p->status == 'proses')
                                            <a href="{{ route('klien.pendaftaran.progress', $p->id) }}" class="text-[9px] bg-indigo-600 text-white px-3 py-2 rounded-lg font-black uppercase hover:bg-indigo-700 transition flex items-center justify-center gap-1 shadow-md">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                Tracking Progress
                                            </a>
                                        @else
                                            <span class="text-[9px] text-gray-400 font-bold uppercase italic tracking-widest">Diterima</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-gray-400 font-medium italic">Belum ada riwayat pendaftaran. Silakan isi form di samping.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
