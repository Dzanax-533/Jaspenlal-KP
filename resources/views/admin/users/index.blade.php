@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-md-2">
        <div>
            <h4 class="fw-800 text-deep-forest mb-1"><i class="fas fa-users-cog me-2 text-primary"></i> Manajemen Pengguna</h4>
            <p class="text-muted small mb-0">Kelola akses akun Admin, Konsultan, Keuangan, dan Klien.</p>
        </div>
        <button class="btn btn-primary rounded-pill shadow-sm px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="fas fa-plus-circle me-1"></i> Tambah User
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small fw-bold text-muted text-uppercase" style="letter-spacing: 0.05em;">
                        <th class="ps-4 py-3">Informasi Akun</th>
                        <th>Username</th>
                        <th>Role / Hak Akses</th>
                        <th>Kontak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr class="border-bottom">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle-xs bg-soft-primary text-primary fw-bold me-3">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $u->name }}</div>
                                    <div class="x-small text-muted">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-medium px-2">{{ $u->username }}</span></td>
                        <td>
                            @php
                                $badgeClass = [
                                    'admin' => 'bg-soft-danger text-danger border-danger',
                                    'konsultan' => 'bg-soft-primary text-primary border-primary',
                                    'keuangan' => 'bg-soft-info text-info border-info',
                                    'klien' => 'bg-soft-success text-success border-success'
                                ][$u->role] ?? 'bg-light';
                            @endphp
                            <span class="badge rounded-pill border {{ $badgeClass }} px-3 py-2" style="font-size: 0.65rem;">
                                {{ strtoupper($u->role) }}
                            </span>
                        </td>
                        <td class="small">{{ $u->no_telepon ?? '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-light border rounded-3" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $u->id }}" title="Edit User">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>

                                {{-- PROTEKSI: Cegah hapus diri sendiri --}}
                                @if($u->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light border rounded-3" title="Hapus User">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light border rounded-3 disabled" title="Anda sedang login">
                                        <i class="fas fa-lock text-muted"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-3 border-top bg-white">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>


{{-- Style Tambahan --}}
<style>
    .avatar-circle-xs { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 0.8rem; }
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-danger { background-color: #fef2f2; }
    .bg-soft-info { background-color: #f0f9ff; }
    .bg-soft-success { background-color: #f0fdf4; }
    .x-small { font-size: 0.75rem; }
</style>

{{-- MODAL LOADERS --}}
@foreach($users as $u)
    @include('admin.users.modal-edit')
@endforeach
@include('admin.users.modal-create')
@endsection
