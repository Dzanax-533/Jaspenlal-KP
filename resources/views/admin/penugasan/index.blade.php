<x-app-layout>
    <x-slot name="header">Pembagian Konsultan</x-slot>

    <div class="py-8">
        <div class="overflow-hidden bg-white shadow-2xl modern-card shadow-slate-100">
            <div class="p-8 border-b border-slate-50">
                <h3 class="text-sm italic font-black tracking-widest uppercase text-slate-800">Antrean Penugasan Konsultan</h3>
                <p class="mt-1 text-xs tracking-tight uppercase text-slate-400">Klien yang telah menyelesaikan pembayaran (Level 3+)</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Klien / Perusahaan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">No. Pendaftaran</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right whitespace-nowrap">Pilih Konsultan Pendamping</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($pengajuans as $item)
                        <tr class="transition-colors hover:bg-indigo-50/20">
                            <td class="px-8 py-6 italic font-bold tracking-tighter uppercase text-slate-800">{{ $item->user->name }}</td>
                            <td class="px-8 py-6 font-mono text-[10px] text-slate-500">#{{ $item->no_pendaftaran }}</td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.assign.store') }}" method="POST" class="flex items-center justify-end gap-3">
                                    @csrf
                                    <input type="hidden" name="pendaftaran_id" value="{{ $item->id }}">
                                    <select name="konsultan_id" required class="text-[10px] font-bold uppercase tracking-widest border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 py-2">
                                        <option value="">-- Pilih Konsultan --</option>
                                        @foreach($konsultans as $k)
                                            <option value="{{ $k->id }}">{{ $k->name }}</button>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-100">
                                        Assign
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 italic font-bold tracking-widest text-center uppercase text-slate-400">Semua klien telah memiliki pendamping</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
