@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    {{-- STATISTIC CARDS --}}
    <div class="mb-4 row g-3">
        <div class="col-md-4">
            <div class="p-3 bg-white border-0 border-4 shadow-sm card rounded-4 h-100 border-start border-warning transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase" style="letter-spacing: 0.05rem;">Antrean Bayar</h6>
                        <h3 class="mb-0 fw-800 text-dark">{{ $stats['pending_payment'] }} <span class="small fw-normal text-muted" style="font-size: 0.8rem;">Invoice</span></h3>
                    </div>
                    <div class="p-3 bg-soft-warning text-warning rounded-circle">
                        <i class="fas fa-file-invoice-dollar fs-5"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top d-flex justify-content-between">
                    <a href="{{ route('keuangan.termin1') }}" class="small text-warning fw-bold text-decoration-none">
                        Termin 1 (DP) <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                    <a href="{{ route('keuangan.termin2') }}" class="small text-primary fw-bold text-decoration-none">
                        Termin 2 (Lunas) <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 bg-white border-0 border-4 shadow-sm card rounded-4 h-100 border-start border-emerald transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase" style="letter-spacing: 0.05rem;">Total Kas Masuk</h6>
                        <h3 class="mb-0 fw-800 text-emerald">Rp {{ number_format($stats['total_verified'], 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-3 bg-soft-emerald text-emerald rounded-circle">
                        <i class="fas fa-wallet fs-5"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top">
                    <span class="small text-muted">Akumulasi Seluruh Pembayaran</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-3 bg-white border-0 border-4 shadow-sm card rounded-4 h-100 border-start border-primary transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase" style="letter-spacing: 0.05rem;">Butuh Pelunasan</h6>
                        <h3 class="mb-0 fw-800 text-primary">{{ $stats['target_pelunasan'] }} <span class="small fw-normal text-muted" style="font-size: 0.8rem;">Klien</span></h3>
                    </div>
                    <div class="p-3 bg-soft-info text-info rounded-circle">
                        <i class="fas fa-hand-holding-usd fs-5"></i>
                    </div>
                </div>
                <div class="pt-2 mt-2 border-top">
                    <span class="small text-muted">Klien di Level 9 (Siap Lunas)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="row">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-1 fw-800 text-deep-forest">Antrean Verifikasi</h4>
                <span class="px-3 py-2 border shadow-sm badge bg-light text-dark rounded-pill small fw-bold">
                    <i class="fas fa-sync-alt fa-spin me-1 text-emerald"></i> Total: {{ $pembayarans->count() }}
                </span>
            </div>

            <div class="overflow-hidden bg-white border-0 shadow-sm card rounded-4">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle table-hover">
                        <thead class="bg-light">
                            <tr class="text-muted small fw-bold text-uppercase">
                                <th class="py-3 ps-4">Klien / No. Reg</th>
                                <th>Termin</th>
                                <th>Nominal Transfer</th>
                                <th>Bukti Gambar</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $p)
                                <tr>
                                    <td class="py-3 ps-4">
                                        <div class="fw-bold text-dark">{{ $p->pendaftaran->user->name }}</div>
                                        <code class="small text-primary">{{ $p->pendaftaran->no_pendaftaran }}</code>
                                    </td>
                                    <td>
                                        @if($p->termin == '1')
                                            <span class="badge bg-soft-warning text-warning px-3 rounded-pill">DP 60%</span>
                                        @else
                                            <span class="badge bg-soft-primary text-primary px-3 rounded-pill">Pelunasan 40%</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                    <td>
                                        <button type="button" class="btn-view-evidence btn-show-proof"
                                            data-url="{{ asset('storage/' . $p->bukti_transfer) }}"
                                            data-name="{{ $p->pendaftaran->user->name }}">
                                            <i class="fas fa-image me-1"></i> Preview
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="gap-2 d-flex justify-content-center">
                                            <form action="{{ route('keuangan.verifikasi', $p->id) }}" method="POST" onsubmit="return confirm('Sahkan pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="btn-action-base btn-success-modern px-3">
                                                    <i class="fas fa-check me-1"></i> Terima
                                                </button>
                                            </form>
                                            <button type="button" class="btn-action-base btn-reject-modern px-3 btn-reject-trigger"
                                                data-url="{{ route('keuangan.tolak', $p->id) }}"
                                                data-name="{{ $p->pendaftaran->user->name }}">
                                                <i class="fas fa-times me-1"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" height="80" class="mb-3 opacity-25">
                                        <p class="mb-0 small">Tidak ada antrean pembayaran yang perlu diproses.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW BUKTI --}}
<div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <div class="p-3 border-0 modal-header bg-light">
                <h6 class="mb-0 modal-title fw-bold">Bukti Bayar: <span id="proofOwnerName" class="text-muted small"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="p-0 overflow-hidden text-center modal-body bg-dark d-flex align-items-center justify-content-center" style="min-height: 300px;">
                <div id="loadingProof" class="text-white position-absolute d-none">
                    <i class="fas fa-circle-notch fa-spin fa-2x"></i>
                </div>
                <img src="" id="proofImage" class="img-fluid" style="max-height: 80vh; width: auto;" alt="Bukti Transfer">
            </div>
        </div>
    </div>
</div>

{{-- MODAL PENOLAKAN --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <form id="formReject" action="" method="POST">
                @csrf
                <div class="pt-4 border-0 modal-header ps-4">
                    <h5 class="mb-0 fw-bold">Konfirmasi Penolakan</h5>
                </div>
                <div class="p-4 modal-body">
                    <label class="mb-2 small fw-bold text-muted text-uppercase">Alasan Penolakan</label>
                    <textarea name="alasan_tolak" id="alasan_tolak" class="p-3 border-0 form-control rounded-3 bg-light" rows="4" placeholder="Contoh: Gambar bukti transfer tidak terbaca atau nominal tidak sesuai..." required></textarea>
                </div>
                <div class="p-4 pt-0 border-0 modal-footer">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-3 fw-bold shadow-sm">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .bg-soft-warning { background-color: #fffbeb; }
    .bg-soft-emerald { background-color: #f0fdf4; }
    .bg-soft-info { background-color: #f0f9ff; }
    .text-emerald { color: #16a34a !important; }
    .btn-action-base { height: 34px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; border: none; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
    .btn-success-modern { background: #16a34a; color: white; }
    .btn-success-modern:hover { background: #15803d; transform: translateY(-2px); }
    .btn-reject-modern { background: #fff1f2; color: #e11d48; }
    .btn-reject-modern:hover { background: #e11d48; color: white; transform: translateY(-2px); }
    .btn-view-evidence { border: 1px solid #e2e8f0; background: white; padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; transition: 0.2s; cursor: pointer; }
    .btn-view-evidence:hover { background: #f8fafc; border-color: #cbd5e1; }
    .transition-hover:hover { transform: translateY(-3px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const proofModalEl = document.getElementById('proofModal');
    const rejectModalEl = document.getElementById('rejectModal');

    // Inisialisasi Instance Bootstrap Modal
    const bsProofModal = new bootstrap.Modal(proofModalEl);
    const bsRejectModal = new bootstrap.Modal(rejectModalEl);

    const proofImage = document.getElementById('proofImage');
    const proofOwnerName = document.getElementById('proofOwnerName');
    const loadingProof = document.getElementById('loadingProof');
    const formReject = document.getElementById('formReject');

    // Event Delegation untuk menangkap klik
    document.addEventListener('click', function (event) {

        // Logika Preview Bukti
        const proofBtn = event.target.closest('.btn-show-proof');
        if (proofBtn) {
            event.preventDefault();
            const url = proofBtn.getAttribute('data-url');
            const name = proofBtn.getAttribute('data-name');

            proofImage.style.opacity = '0';
            loadingProof.classList.remove('d-none');

            proofOwnerName.textContent = name;
            proofImage.src = url;
            bsProofModal.show();

            proofImage.onload = function() {
                loadingProof.classList.add('d-none');
                proofImage.style.opacity = '1';
                proofImage.style.transition = 'opacity 0.3s ease';
            };
        }

        // Logika Modal Tolak
        const rejectBtn = event.target.closest('.btn-reject-trigger');
        if (rejectBtn) {
            event.preventDefault();
            const url = rejectBtn.getAttribute('data-url');
            formReject.action = url;
            bsRejectModal.show();
        }
    });

    // Reset Image saat modal tutup agar tidak flash gambar lama
    proofModalEl.addEventListener('hidden.bs.modal', function () {
        proofImage.src = '';
    });
});
</script>
@endsection
