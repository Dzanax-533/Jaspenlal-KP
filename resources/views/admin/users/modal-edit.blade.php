<div class="modal fade" id="modalEditUser{{ $u->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.users.update', $u->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 bg-light px-4">
                <h6 class="modal-title fw-bold">Edit Akun: {{ $u->name }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-start">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $u->name }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1">Role</label>
                        <select name="role" class="form-select rounded-3" required>
                            <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="konsultan" {{ $u->role == 'konsultan' ? 'selected' : '' }}>Konsultan</option>
                            <option value="keuangan" {{ $u->role == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                            <option value="klien" {{ $u->role == 'klien' ? 'selected' : '' }}>Klien</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold text-muted mb-1">Telepon</label>
                        <input type="text" name="no_telepon" value="{{ $u->no_telepon }}" class="form-control rounded-3">
                    </div>
                    <div class="col-12">
                        <label class="small fw-bold text-muted mb-1">Email</label>
                        <input type="email" name="email" value="{{ $u->email }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-warning border-0 small mb-0 py-2 rounded-3">
                            <i class="fas fa-info-circle me-1"></i> Biarkan password kosong jika tidak ingin diubah.
                        </div>
                        <label class="small fw-bold text-muted mt-2 mb-1">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control rounded-3" minlength="8">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
