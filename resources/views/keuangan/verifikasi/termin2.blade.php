@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid px-md-5">
    <div class="mb-4 row">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold text-deep-forest">Verifikasi Pelunasan - Termin 2 (40%)</h4>
                <p class="text-muted small">Konfirmasi pembayaran pelunasan untuk proses Level 10 (Penerbitan Sertifikat).</p>
            </div>
            <div class="px-3 py-2 border shadow-sm badge bg-soft-primary text-primary rounded-pill border-primary border-opacity-10">
                <i class="fas fa-check-double me-1"></i> Tahap Pelunasan Final
            </div>
        </div>
    </div>

    <div class="overflow-hidden bg-white border-0 shadow-sm card rounded-4">
        <div class="p-0 card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover">
                    <thead class="bg-light">
                        <tr class="small fw-bold text-muted text-uppercase" style="letter-spacing: 0.05em;">
                            <th class="py-3 ps-4">Klien / No. Daftar</th>
                            <th>Detail Tagihan (40%)</th>
                            <th class="text-center">Bukti Transfer</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $p->pendaftaran->user->name }}</div>
                                <small class="mt-1 text-muted d-block">
                                    <span class="border badge bg-light text-dark me-1">{{ $p->pendaftaran->no_pendaftaran }}</span>
                                </small>
                            </td>
                            <td>
                                <div class="fw-bold text-emerald">Rp {{ number_format($p->nominal, 0, ',', '.') }}</div>
                                {{-- Menampilkan informasi paket untuk memudahkan pengecekan nominal --}}
                                <div style="font-size: 0.7rem;" class="mt-1 text-muted text-uppercase fw-bold">
                                    <i class="fas fa-box me-1"></i> {{ $p->pendaftaran->paket->nama_paket ?? 'Paket Kustom' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="px-3 btn btn-sm btn-outline-primary rounded-pill btn-show-proof"
                                    data-url="{{ asset('storage/' . $p->bukti_transfer) }}"
                                    data-name="{{ $p->pendaftaran->user->name }}">
                                    <i class="fas fa-search me-1"></i> Periksa Bukti
                                </button>
                            </td>
                            <td class="small text-muted">
                                {{ $p->created_at->translatedFormat('d M Y') }}
                                <div style="font-size: 0.7rem;">{{ $p->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="gap-2 d-flex justify-content-center">
                                    <form action="{{ route('keuangan.verifikasi', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 shadow-sm btn btn-primary btn-sm rounded-3" onclick="return confirm('Pastikan dana sudah masuk ke mutasi bank. Setelah diverifikasi, klien akan lanjut ke tahap Penerbitan Sertifikat (Level 10).')">
                                            <i class="fas fa-check-circle me-1"></i> Konfirmasi Lunas
                                        </button>
                                    </form>
                                    <button type="button" class="px-3 btn btn-outline-danger btn-sm rounded-3 btn-reject-trigger"
                                            data-url="{{ route('keuangan.tolak', $p->id) }}"
                                            data-name="{{ $p->pendaftaran->user->name }}">
                                        <i class="fas fa-times-circle me-1"></i> Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center">
                                <div class="py-3">
                                    <i class="mb-3 fas fa-receipt fa-3x text-light"></i>
                                    <h6 class="text-muted fw-bold">Tidak ada antrean pelunasan</h6>
                                    <p class="mb-0 text-muted small">Semua pendaftaran sudah terverifikasi atau belum mengunggah bukti.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- --- MODAL SECTION --- --}}

{{-- Modal Preview Gambar --}}
<div class="modal fade" id="proofModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="border-0 shadow-lg modal-content rounded-4">
            <div class="p-3 border-0 modal-header bg-light">
                <h6 class="mb-0 modal-title fw-bold">Pratinjau Bukti Transfer: <span id="proofOwnerName" class="text-primary small"></span></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-0 overflow-hidden text-center modal-body bg-dark">
                <img src="" id="proofImage" class="img-fluid" style="max-height: 75vh; width: auto;" alt="Bukti Transfer">
            </div>
            <div class="py-2 border-0 modal-footer bg-light justify-content-center">
                <a href="" id="downloadProof" target="_blank" class="btn btn-sm btn-link text-primary text-decoration-none small fw-bold">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Gambar Penuh / Download
                </a>
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
                <div class="pt-4 border-0 modal-header ps-4 d-flex align-items-center">
                    <div class="p-2 bg-danger bg-opacity-10 text-danger rounded-circle me-3">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Tolak Bukti Bayar</h5>
                        <small class="text-muted" id="rejectTargetName"></small>
                    </div>
                </div>
                <div class="p-4 modal-body">
                    <label class="mb-2 small fw-bold text-muted text-uppercase">Alasan Penolakan</label>
                    <textarea name="alasan_tolak" class="p-3 border-0 form-control rounded-3 bg-light" rows="4" placeholder="Jelaskan alasan penolakan agar klien dapat memperbaiki pembayaran..." required></textarea>
                </div>
                <div class="gap-2 p-4 pt-0 border-0 modal-footer d-flex">
                    <button type="button" class="btn btn-light flex-grow-1 rounded-3 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="shadow-sm btn btn-danger flex-grow-1 rounded-3 fw-bold">Kirim & Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #e0f2fe; }
    .text-emerald { color: #10b981 !important; }
    .x-small { font-size: 0.75rem; }
    .text-deep-forest { color: #1a2e2a; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const proofModalObj = new bootstrap.Modal(document.getElementById('proofModal'));
    const rejectModalObj = new bootstrap.Modal(document.getElementById('rejectModal'));

    document.addEventListener('click', function (event) {
        const proofBtn = event.target.closest('.btn-show-proof');
        if (proofBtn) {
            const url = proofBtn.getAttribute('data-url');
            const name = proofBtn.getAttribute('data-name');
            document.getElementById('proofImage').src = url;
            document.getElementById('downloadProof').href = url;
            document.getElementById('proofOwnerName').textContent = name;
            proofModalObj.show();
        }

        const rejectBtn = event.target.closest('.btn-reject-trigger');
        if (rejectBtn) {
            const url = rejectBtn.getAttribute('data-url');
            const name = rejectBtn.getAttribute('data-name');
            document.getElementById('formReject').action = url;
            document.getElementById('rejectTargetName').textContent = 'Klien: ' + name;
            rejectModalObj.show();
        }
    });
});
</script>
@endsection
