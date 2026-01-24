@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1 fw-bold text-primary"><i class="fas fa-gavel me-2"></i> Sidang Fatwa</h5>
            <p class="mb-0 text-muted small">Daftar pendaftaran yang telah selesai audit dan menunggu Ketetapan Halal (Level 8).</p>
        </div>
    </div>

    <div class="overflow-hidden border-0 shadow-sm card rounded-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="py-3 ps-4">No. Registrasi / Perusahaan</th>
                        <th>Konsultan Auditor</th>
                        <th class="text-center">LHA (Hasil Audit)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td class="ps-4">
                            <div class="font-monospace fw-bold text-primary small">{{ $row->no_pendaftaran }}</div>
                            <div class="small fw-bold text-dark">{{ $row->user->klienDetail->nama_perusahaan ?? $row->user->name }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-soft-primary text-primary rounded-circle me-2">
                                    {{ substr($row->konsultan->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="small fw-bold">{{ $row->konsultan->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($row->file_lha)
                                <a href="{{ route('admin.operasional.sidang.view_lha', $row->id) }}" target="_blank" class="px-3 btn btn-sm btn-outline-info rounded-pill">
                                    <i class="fas fa-file-pdf me-1"></i> Lihat LHA
                                </a>
                            @else
                                <span class="text-muted small">Belum Unggah</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="px-3 btn btn-sm btn-warning rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalSidang{{ $row->id }}">
                                <i class="fas fa-upload me-1"></i> Upload Ketetapan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-5 text-center text-muted">
                            <i class="mb-3 opacity-25 fas fa-gavel fa-3x"></i>
                            <p class="mb-0">Belum ada antrean sidang fatwa.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DILETAKKAN DI LUAR TABLE / CARD UTAMA AGAR TIDAK TUMPANG TINDIH --}}
@foreach($data as $row)
<div class="modal fade" id="modalSidang{{ $row->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <form action="{{ route('admin.operasional.sidang.upload', $row->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 border-0 modal-header bg-warning text-dark">
                    <h6 class="modal-title fw-bold" id="modalLabel{{ $row->id }}">
                        <i class="fas fa-certificate me-2"></i>Ketetapan Halal: {{ $row->no_pendaftaran }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-4 modal-body">
                    <div class="mb-4 border-0 alert alert-info small rounded-3">
                        <i class="fas fa-info-circle me-2"></i> Input hasil sidang untuk melanjutkan ke <strong>Level 9 (Pelunasan)</strong>.
                    </div>

                    <div class="mb-3">
                        <label class="mb-1 small fw-bold text-muted">Tanggal Sidang Fatwa</label>
                        <input type="date" name="tgl_sidang" class="shadow-sm form-control rounded-3 border-light" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="mb-0">
                        <label class="mb-1 small fw-bold text-muted">File Ketetapan Halal (PDF)</label>
                        <input type="file" name="file_ketetapan_halal" class="shadow-sm form-control rounded-3 border-light" accept=".pdf" required>
                        <div class="mt-1 form-text x-small text-danger">Maksimum file: 5MB.</div>
                    </div>
                </div>
                <div class="p-4 pt-0 border-0 modal-footer">
                    <button type="button" class="px-4 btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="px-4 shadow-sm btn btn-primary rounded-3 fw-bold btn-submit-sidang">
                            <span class="btn-text">Simpan & Kirim Tagihan <i class="fas fa-paper-plane ms-1"></i></span>
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .avatar-sm { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 11px; }
    .x-small { font-size: 0.75rem; }
    /* Menghilangkan tumpang tindih backdrop */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
</style>

<script>
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('.btn-submit-sidang');
            if(btn) {
                btn.disabled = true;
                btn.querySelector('.btn-text').innerText = 'Memproses...';
                btn.querySelector('.spinner-border').classList.remove('d-none');
            }
        });
    });
</script>
@endsection
