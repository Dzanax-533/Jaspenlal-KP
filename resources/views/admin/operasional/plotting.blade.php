@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-primary"><i class="fas fa-user-tag me-2"></i> Plotting Konsultan</h5>
            <p class="text-muted small mb-0">Pendaftaran yang sudah bayar DP dan menunggu penugasan konsultan.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase">
                        <th class="ps-4 py-3">No. Registrasi</th>
                        <th>Klien / Perusahaan</th>
                        <th>Paket</th>
                        <th>Pilih Konsultan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                    <tr>
                        <td class="ps-4 font-monospace fw-bold text-primary">{{ $row->no_pendaftaran }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $row->user->name }}</div>
                            <div class="small text-muted">{{ $row->klienDetail->nama_perusahaan ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal">
                                {{ $row->paket->nama_paket ?? 'Reguler' }}
                            </span>
                        </td>

                        {{-- Form Penugasan Konsultan --}}
                        <td>
                            <form id="formAssign{{ $row->id }}" action="{{ route('admin.operasional.assign') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="pendaftaran_id" value="{{ $row->id }}">
                                    <select name="konsultan_id" class="form-select form-select-sm rounded-3 shadow-none border-primary" required>
                                        <option value="" disabled selected>-- Pilih Konsultan --</option>
                                        @foreach($konsultans as $k)
                                            {{-- Menampilkan angka beban tugas --}}
                                            <option value="{{ $k->id }}">
                                                {{ $k->name }} — ({{ $k->pendampingans_count }} Tugas Aktif)
                                            </option>
                                        @endforeach
                                    </select>
                            </form>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="submit" form="formAssign{{ $row->id }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
                                    <i class="fas fa-paper-plane me-1"></i> Tugaskan
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $row->id }}">
                                    <i class="fas fa-times me-1"></i> Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                            <p class="mb-0">Tidak ada pendaftaran yang menunggu plotting saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tolak --}}
@foreach($data as $row)
<div class="modal fade" id="modalTolak{{ $row->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        {{-- Perbaikan: Memastikan rute sesuai dengan struktur grup operasional --}}
        <form action="{{ route('admin.operasional.pendaftaran.tolak', $row->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 bg-danger text-white px-4">
                <h6 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Tolak Pendaftaran</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-light border-0 small mb-3">
                    Anda akan menolak pendaftaran <strong>{{ $row->no_pendaftaran }}</strong>. Perusahaan akan melihat alasan ini di dashboard mereka.
                </div>
                <div class="mb-0">
                    <label class="small fw-bold text-muted mb-1">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" class="form-control rounded-3" rows="4" required
                        placeholder="Berikan alasan yang jelas, misal: Dokumen NIB tidak valid..."></textarea>
                    <div class="form-text text-xs italic">Sebutkan alasan teknis agar klien dapat memperbaiki data.</div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger rounded-3 px-4 shadow-sm">Konfirmasi Tolak</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
