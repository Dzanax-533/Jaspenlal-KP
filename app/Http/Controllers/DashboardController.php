<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. DASHBOARD KLIEN
        if ($user->role === 'klien') {
            // PERBAIKAN: Menambahkan 'pembayarans' agar status verifikasi keuangan terbaca di Blade
            $pendaftaran = Pendaftaran::with(['paket', 'konsultan', 'pembayarans'])
                ->where('user_id', $user->id)
                ->latest()
                ->first();

            return view('dashboard', compact('pendaftaran'));
        }

        // 2. DASHBOARD KONSULTAN
        if ($user->role === 'konsultan') {
            $stats = [
                'perlu_validasi'   => Pendaftaran::where('progress_level', 5)->where('konsultan_id', $user->id)->count(),
                'evaluasi_bahan'   => Pendaftaran::where('progress_level', 6)->where('konsultan_id', $user->id)->count(),
                'jadwal_audit'     => Pendaftaran::where('progress_level', 7)->where('konsultan_id', $user->id)->count(),
                'total_tugas'      => Pendaftaran::whereIn('progress_level', [4, 5, 6, 7])->where('konsultan_id', $user->id)->count(),
                'perlu_verifikasi' => Pendaftaran::where('progress_level', 5)->where('konsultan_id', $user->id)->count(),
            ];

            $tugas = Pendaftaran::with(['user', 'paket'])
                ->where('konsultan_id', $user->id)
                ->whereIn('progress_level', [4, 5, 6, 7])
                ->latest()
                ->limit(10)
                ->get();

            $pendampingans = Pendaftaran::with(['user', 'dokumens'])
                ->where('konsultan_id', $user->id)
                ->whereIn('progress_level', [4, 5, 6, 7])
                ->latest()
                ->paginate(10);

            return view('konsultan.dashboard', compact('stats', 'pendampingans', 'tugas'));
        }

        // 3. DASHBOARD KEUANGAN
        if ($user->role === 'keuangan') {
            $stats = [
                'pending_payment'  => Pembayaran::where('status_verifikasi', 'pending')->count(),
                'total_verified'   => Pembayaran::where('status_verifikasi', 'verified')->sum('nominal'),
                'target_pelunasan' => Pendaftaran::where('progress_level', 9)->count(),
            ];

            $pembayarans = Pembayaran::with(['pendaftaran.user'])
                ->where('status_verifikasi', 'pending')
                ->latest()
                ->get();

            return view('keuangan.dashboard', compact('stats', 'pembayarans'));
        }

        // 4. DASHBOARD ADMIN
        if ($user->role === 'admin') {
            $stats = [
                'pending_plotting'   => Pendaftaran::where('progress_level', 3)->count(),
                'pending_sidang'     => Pendaftaran::where('progress_level', 8)->count(),
                'pending_sertifikat' => Pendaftaran::where('progress_level', 10)->count(),
                'total_klien'        => User::where('role', 'klien')->count(),
                'total_ditolak'      => Pendaftaran::where('status', 'Ditolak')->count(),
            ];

            $pendaftaranTerbaru = Pendaftaran::with('user')
                ->whereIn('progress_level', [1, 2, 3])
                ->latest()
                ->take(5)
                ->get();

            $logPenolakan = \App\Models\Pendaftaran::with('user')
                ->where('status', 'Ditolak') // Sesuaikan dengan string status di database Anda
                ->latest()
                ->limit(5)
                ->get();

            $konsultans = \App\Models\User::where('role', 'konsultan')->get();

            return view('admin.dashboard', compact('stats', 'pendaftaranTerbaru', 'logPenolakan', 'konsultans'));
        }

        abort(403);
    }
}
