@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- HEADER & STATS --}}
    <div class="mb-4 row align-items-center">
        <div class="col-md-6">
            <h3 class="fw-800 text-deep-forest mb-1">Dashboard Konsultan</h3>
            <p class="text-muted small">Halo {{ auth()->user()->name }}, Anda memiliki {{ $stats['total_tugas'] }} antrean pendampingan aktif.</p>
        </div>
        <div class="col-md-6">
            <div class="row g-2 justify-content-md-end">
                <div class="col-auto">
                    <div class="bg-white border-0 shadow-sm card rounded-4 px-3 py-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-soft-primary text-primary rounded-circle me-3">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block x-small fw-bold text-uppercase">Total Tugas</small>
                                <h5 class="mb-0 fw-bold">{{ $stats['total_tugas'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="bg-white border-0 shadow-sm card rounded-4 px-3 py-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-soft-warning text-warning rounded-circle me-3">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block x-small fw-bold text-uppercase">Perlu Verifikasi</small>
                                <h5 class="mb-0 fw-bold">{{ $stats['perlu_verifikasi'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TUGAS AKTIF (LEVEL 5 & 6) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-deep-forest">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>Tugas Verifikasi Berkas & Bahan (Lvl 5-6)
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle table-hover">
                        <thead class="bg-light">
                            <tr class="small fw-bold text-muted text-uppercase">
                                <th class="ps-4 py-3">Nama Klien</th>
                                <th>No. Pendaftaran</th>
                                <th>Tahapan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $row)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $row->user->name }}</div>
                                    <small class="text-muted">{{ $row->user->klienDetail->nama_perusahaan ?? 'Perusahaan Belum Diisi' }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border fw-normal">{{ $row->no_pendaftaran }}</span></td>
                                <td>
                                    @if($row->progress_level == 5)
                                        <span class="badge bg-soft-info text-info rounded-pill px-3">Verifikasi Berkas</span>
                                    @elseif($row->progress_level == 6)
                                        <span class="badge bg-soft-warning text-warning rounded-pill px-3">Verifikasi Bahan</span>
                                    @else
                                        <span class="badge bg-soft-secondary text-secondary rounded-pill px-3">Level {{ $row->progress_level }}</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    {{-- PERBAIKAN 1: Menggunakan rute 'konsultan.evaluasi.show' sesuai web.php Anda --}}
                                    <a href="{{ route('konsultan.evaluasi.show', $row->id) }}"
                                       class="btn {{ $row->progress_level == 5 ? 'btn-primary' : 'btn-warning' }} btn-sm rounded-3 px-3 shadow-sm">
                                        <i class="fas {{ $row->progress_level == 5 ? 'fa-file-search' : 'fa-flask' }} me-1"></i>
                                        {{ $row->progress_level == 5 ? 'Periksa Berkas' : 'Evaluasi Bahan' }}
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">Tidak ada tugas verifikasi aktif.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SELURUH ANTREAN PENDAMPINGAN --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-deep-forest">
                        <i class="fas fa-layer-group me-2 text-emerald"></i>Riwayat & Antrean Progres
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="bg-light">
                            <tr class="small fw-bold text-muted text-uppercase">
                                <th class="ps-4 py-3">Klien</th>
                                <th>Progres</th>
                                <th>Berkas</th>
                                <th class="text-center">Tinjau Cepat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendampingans as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold small">{{ $p->user->name }}</div>
                                    <div class="x-small text-muted">{{ $p->no_pendaftaran }}</div>
                                </td>
                                <td>
                                    <div class="progress rounded-pill" style="height: 6px; width: 100px;">
                                        <div class="progress-bar bg-emerald" style="width: {{ ($p->progress_level / 9) * 100 }}%"></div>
                                    </div>
                                    <small class="x-small text-muted">Level {{ $p->progress_level }}/9</small>
                                </td>
                                <td>
                                    <span class="small fw-bold">
                                        <i class="fas fa-file-alt me-1 text-primary"></i>
                                        {{ $p->dokumens->count() }} File
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-light btn-sm border rounded-pill px-3 btn-view-docs"
                                        data-name="{{ $p->user->name }}"
                                        data-docs='@json($p->dokumens)'>
                                        <i class="fas fa-eye text-primary"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW DOKUMEN --}}
<div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 bg-light rounded-top-4">
                <h6 class="modal-title fw-bold">Berkas: <span id="clientName" class="text-muted small"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div id="docList" class="list-group list-group-flush"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .text-deep-forest { color: #1a2e2a; }
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-warning { background-color: #fffbeb; }
    .bg-soft-info { background-color: #e0f2fe; }
    .bg-emerald { background-color: #10b981; }
    .text-emerald { color: #10b981 !important; }
    .x-small { font-size: 0.75rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const docModal = new bootstrap.Modal(document.getElementById('docModal'));

    document.addEventListener('click', function (event) {
        const btn = event.target.closest('.btn-view-docs');
        if (btn) {
            const name = btn.dataset.name;
            const docs = JSON.parse(btn.dataset.docs || '[]');
            const list = document.getElementById('docList');

            document.getElementById('clientName').textContent = name;
            list.innerHTML = '';

            if (docs.length === 0) {
                list.innerHTML = '<div class="p-4 text-center text-muted small">Belum ada dokumen yang diunggah klien.</div>';
            } else {
                docs.forEach(doc => {
                    // PERBAIKAN 2: Menggunakan 'status' sesuai kolom database Anda
                    const statusDoc = doc.status || 'pending';
                    const badgeClass = statusDoc === 'approved' ? 'bg-success' : (statusDoc === 'rejected' ? 'bg-danger' : 'bg-warning');

                    list.innerHTML += `
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                            <div>
                                <div class="small fw-bold text-dark text-uppercase">${doc.nama_dokumen.replace(/_/g, ' ')}</div>
                                <div class="x-small">
                                    <span class="badge ${badgeClass} rounded-pill">${statusDoc}</span>
                                </div>
                            </div>
                            <a href="/konsultan/evaluasi/view-file/${doc.id}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>`;
                });
            }
            docModal.show();
        }
    });
});
</script>
@endsection
