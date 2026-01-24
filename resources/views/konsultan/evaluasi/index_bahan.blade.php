@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-1 fw-bold text-deep-forest">Daftar Evaluasi Bahan</h4>
            <p class="text-muted small">Pengecekan kehalalan bahan baku dan tambahan (Level 4).</p>
        </div>
    </div>

    <div class="overflow-hidden border-0 shadow-sm card rounded-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle table-hover">
                <thead class="bg-light text-uppercase small fw-bold text-muted">
                    <tr>
                        <th class="py-3 ps-4">Klien</th>
                        <th>Total Bahan</th>
                        <th>Jadwal Audit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendampingans as $p)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                            <small class="text-muted">{{ $p->no_pendaftaran }}</small>
                        </td>
                        <td>
                            <span class="px-3 badge bg-soft-warning text-warning rounded-pill">
                                <i class="fas fa-flask me-1"></i> {{ $p->bahans->count() }} Item
                            </span>
                        </td>
                        <td>
                            @if($p->tgl_audit)
                                <small class="fw-bold text-emerald"><i class="fas fa-calendar-check me-1"></i> {{ \Carbon\Carbon::parse($p->tgl_audit)->format('d M Y') }}</small>
                            @else
                                <small class="italic text-muted">Belum dijadwalkan</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('konsultan.evaluasi.show', $p->id) }}" class="px-3 btn btn-sm btn-warning rounded-3 text-dark fw-bold">
                                <i class="fas fa-clipboard-list me-1"></i> Evaluasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-5 text-center text-muted">Tidak ada antrean evaluasi bahan saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
