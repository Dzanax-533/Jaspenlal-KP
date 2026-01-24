<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 text-start">
            @csrf
            <div class="modal-header border-0 bg-light px-4 py-3">
                <h6 class="modal-title fw-bold text-deep-forest"><i class="fas fa-user-plus me-2"></i>Tambah Akun Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3 bg-light border-0 py-2" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Username</label>
                        <input type="text" name="username" class="form-control rounded-3 bg-light border-0 py-2" required placeholder="budis123">
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Role Akses</label>
                        <select name="role" class="form-select rounded-3 bg-light border-0 py-2" required>
                            <option value="admin">Admin</option>
                            <option value="konsultan" selected>Konsultan</option>
                            <option value="keuangan">Keuangan</option>
                            <option value="klien">Klien</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Email Resmi</label>
                        <input type="email" name="email" class="form-control rounded-3 bg-light border-0 py-2" required placeholder="budi@example.com">
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Nomor Telepon/WA</label>
                        <input type="text" name="no_telepon" class="form-control rounded-3 bg-light border-0 py-2" placeholder="0812xxxxxx">
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1 text-uppercase" style="font-size: 0.65rem;">Password Awal</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control rounded-start-3 bg-light border-0 py-2" required minlength="8" placeholder="Minimal 8 karakter">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-eye-slash text-muted small"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm-primary">
                    <i class="fas fa-save me-1"></i> Daftarkan Akun
                </button>
            </div>
        </form>
    </div>
</div>
