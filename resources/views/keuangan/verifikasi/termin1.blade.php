@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 row">
        <div class="col-12">
            <h4 class="fw-bold text-deep-forest">Verifikasi Pembayaran - Termin 1 (DP 60%)</h4>
            <p class="text-muted small">Daftar antrean uang muka yang masuk untuk diproses ke Level 3.</p>
        </div>
    </div>

    <div class="overflow-hidden bg-white border-0 shadow-sm card rounded-4">
        <div class="p-0 card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover">
                    <thead class="bg-light">
                        <tr class="small fw-bold text-muted text-uppercase">
                            <th class="py-3 ps-4">Klien / No. Daftar</th>
                            <th>Nominal DP (60%)</th>
                            <th class="text-center">Bukti Transfer</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $p->pendaftaran->user->name }}</div>
                                <small class="text-muted">{{ $p->pendaftaran->no_pendaftaran }}</small>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="px-3 btn btn-sm btn-outline-info rounded-pill btn-show-proof"
                                    data-url="{{ asset('storage/' . $p->bukti_transfer) }}"
                                    data-name="{{ $p->pendaftaran->user->name }}">
                                    <i class="fas fa-image me-1"></i> Periksa
                                </button>
                            </td>
                            <td class="small text-muted">{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center pe-4">
                                <div class="gap-2 d-flex justify-content-center">
                                    <form action="{{ route('keuangan.verifikasi', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 btn btn-success btn-sm rounded-3 shadow-sm">
                                            <i class="fas fa-check me-1"></i> Terima
                                        </button>
                                    </form>
                                    <button type="button" class="px-3 btn btn-danger btn-sm rounded-3 shadow-sm btn-reject-trigger"
                                            data-url="{{ route('keuangan.tolak', $p->id) }}"
                                            data-name="{{ $p->pendaftaran->user->name }}">
                                        <i class="fas fa-times me-1"></i> Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center">
                                <h6 class="text-muted">Tidak ada antrean pembayaran Termin 1.</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- --- MODAL SECTION (DI DALAM FILE) --- --}}

{{-- Modal Lihat Bukti --}}
<div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <div class="p-3 border-0 modal-header bg-light">
                <h6 class="mb-0 modal-title fw-bold">Bukti Transfer: <span id="proofOwnerName" class="text-muted small"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-0 overflow-hidden text-center modal-body bg-dark">
                <img src="" id="proofImage" class="img-fluid" style="max-height: 75vh; width: auto;">
            </div>
        </div>
    </div>
</div>

{{-- Modal Alasan Tolak --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <form id="formReject" action="" method="POST">
                @csrf
                <div class="pt-4 border-0 modal-header ps-4">
                    <h5 class="mb-0 fw-bold">Konfirmasi Penolakan</h5>
                </div>
                <div class="p-4 modal-body">
                    <textarea name="alasan_tolak" class="form-control rounded-3 bg-light" rows="4" placeholder="Alasan penolakan..." required></textarea>
                </div>
                <div class="p-4 pt-0 border-0 modal-footer">
                    <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gunakan delegasi event agar tidak ada modal yang bertumpuk (Shadow hitam ganda)
    document.addEventListener('click', function (event) {

        // 1. Logic Modal Bukti
        const proofBtn = event.target.closest('.btn-show-proof');
        if (proofBtn) {
            document.getElementById('proofImage').src = proofBtn.getAttribute('data-url');
            document.getElementById('proofOwnerName').textContent = proofBtn.getAttribute('data-name');
            const modal = new bootstrap.Modal(document.getElementById('proofModal'));
            modal.show();
        }

        // 2. Logic Modal Tolak
        const rejectBtn = event.target.closest('.btn-reject-trigger');
        if (rejectBtn) {
            document.getElementById('formReject').action = rejectBtn.getAttribute('data-url');
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    });
});
</script>
@endsection
