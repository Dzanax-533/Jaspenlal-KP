@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- Header --}}
    <div class="mb-4 row align-items-center">
        <div class="col-md-8">
            <h4 class="mb-1 fw-800 text-deep-forest">Antrean Audit Lapangan</h4>
            <p class="text-muted small">Daftar pendaftaran yang telah melewati evaluasi bahan dan siap untuk proses audit lapangan (Level 7).</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="px-3 py-2 bg-white border shadow-sm badge text-dark rounded-pill">
                <i class="fas fa-clipboard-list me-1 text-primary"></i> {{ $pendampingans->count() }} Antrean Audit
            </div>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="mb-4 text-white border-0 shadow-sm card rounded-4 bg-primary">
        <div class="p-4 card-body d-flex align-items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-circle me-4">
                <i class="fas fa-info-circle fs-3"></i>
            </div>
            <div>
                <h6 class="mb-1 fw-bold">Instruksi Auditor</h6>
                <p class="mb-0 opacity-75 small">Silakan lakukan kunjungan lapangan sesuai jadwal, lalu unggah Laporan Hasil Audit (LHA). Setelah LHA diunggah, pendaftaran akan otomatis diteruskan ke Sidang Fatwa (Level 8).</p>
            </div>
        </div>
    </div>

    {{-- Table Antrean Audit --}}
    <div class="overflow-hidden bg-white border-0 shadow-sm card rounded-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle table-hover">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="py-3 ps-4">Informasi Klien</th>
                        <th>Jadwal Kunjungan</th> {{-- KOLOM BARU --}}
                        <th>Lokasi / Perusahaan</th>
                        <th class="text-center">Status Audit</th>
                        <th class="text-center pe-4">Pengerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendampingans as $p)
                    <tr>
                        <td class="py-3 ps-4">
                            <div class="fw-bold text-dark">{{ $p->user->name }}</div>
                            <div class="x-small text-muted">ID: {{ $p->no_pendaftaran }}</div>
                        </td>
                        <td>
                            {{-- MENAMPILKAN TANGGAL DARI LEVEL 6 --}}
                            <div class="fw-bold text-primary small">
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ $p->tgl_audit ? \Carbon\Carbon::parse($p->tgl_audit)->format('d M Y') : 'Belum Set' }}
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold text-deep-forest">{{ $p->klienDetail->nama_perusahaan ?? 'N/A' }}</div>
                            <div class="x-small text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($p->klienDetail->alamat_perusahaan ?? 'Alamat belum diisi', 40) }}</div>
                        </td>
                        <td class="text-center">
                            <span class="px-3 py-2 badge bg-soft-primary text-primary rounded-pill x-small">
                                <i class="fas fa-running me-1"></i> Siap Kunjungi
                            </span>
                        </td>
                        <td class="text-center pe-4">
                            <div class="gap-2 d-flex justify-content-center">
                                <a href="{{ route('konsultan.evaluasi.show', $p->id) }}" class="px-2 border btn btn-light btn-sm rounded-3 transition-hover" title="Lihat Berkas">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('konsultan.audit.form', $p->id) }}" class="px-3 shadow-sm btn btn-primary btn-sm rounded-3 transition-hover">
                                    <i class="fas fa-edit me-1"></i> Buat LHA
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" height="80" class="mb-3 opacity-25">
                            <h6 class="fw-bold">Belum Ada Antrean Audit</h6>
                            <p class="mb-0 small">Pendaftaran akan muncul di sini setelah Level 6 (Bahan) disetujui.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .text-deep-forest { color: #1a2e2a; }
    .bg-soft-primary { background-color: #eef2ff !important; }
    .x-small { font-size: 0.75rem; }
    .transition-hover { transition: all 0.2s ease-in-out; }
    .transition-hover:hover { transform: translateY(-2px); }
</style>
@endsection
