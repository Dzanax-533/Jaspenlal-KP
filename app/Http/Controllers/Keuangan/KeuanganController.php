<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    protected $service;

    public function __construct(PendaftaranService $service)
    {
        $this->service = $service;
    }

    public function dashboard()
    {
        $stats = $this->getStats();
        $pembayarans = Pembayaran::with(['pendaftaran.user', 'pendaftaran.paket'])
                        ->where('status_verifikasi', 'pending')
                        ->latest()
                        ->get();

        return view('keuangan.dashboard', compact('pembayarans', 'stats'));
    }

    public function termin1()
    {
        $stats = $this->getStats();
        $pembayarans = Pembayaran::with(['pendaftaran.user', 'pendaftaran.paket'])
                        ->where('termin', '1')
                        ->where('status_verifikasi', 'pending')
                        ->latest()
                        ->get();

        return view('keuangan.verifikasi.termin1', compact('pembayarans', 'stats'));
    }

    public function termin2()
    {
        $stats = $this->getStats();
        $pembayarans = Pembayaran::with(['pendaftaran.user', 'pendaftaran.paket'])
                        ->where('termin', '2')
                        ->where('status_verifikasi', 'pending')
                        ->latest()
                        ->get();

        return view('keuangan.verifikasi.termin2', compact('pembayarans', 'stats'));
    }

    private function getStats()
    {
        return [
            'pending_payment' => Pembayaran::where('status_verifikasi', 'pending')->count(),
            'total_verified'  => Pembayaran::where('status_verifikasi', 'verified')->sum('nominal'),
            'target_pelunasan' => Pendaftaran::where('progress_level', 9)
                                    ->whereDoesntHave('pembayarans', function($q) {
                                        $q->where('termin', '2')->where('status_verifikasi', 'verified');
                                    })->count(),
        ];
    }

    /**
     * Proses Verifikasi (Terima Pembayaran)
     */
    public function verifikasi(Request $request, $id)
    {
        // Gunakan with('pendaftaran') agar tidak terjadi N+1 query
        $pembayaran = Pembayaran::with('pendaftaran')->findOrFail($id);
        $pendaftaranId = $pembayaran->pendaftaran_id;

        // 1. Update status pembayaran menjadi 'verified'
        $pembayaran->update([
            'status_verifikasi' => 'verified',
            'keterangan' => 'Pembayaran Termin ' . $pembayaran->termin . ' Terverifikasi oleh Keuangan pada ' . now()->format('d/m/Y H:i')
        ]);

        // 2. Alur Kenaikan Level & Sinkronisasi
        if ($pembayaran->termin == '2') {
            // PELUNASAN (Termin 2) -> Klien naik ke Level 10 (Selesai)
            $this->service->updateStep($pendaftaranId, 10);
            $msg = 'Pelunasan berhasil diverifikasi. Pendaftaran selesai.';
        } else {
            // DP (Termin 1) -> Klien naik ke Level (Plotting Konsultan)
            $this->service->updateStep($pendaftaranId, 4);
            $msg = 'DP Berhasil diverifikasi. Klien masuk antrean Plotting (Level 4).';
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Proses Tolak Pembayaran
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|min:5'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        // 1. Update status pembayaran menjadi 'rejected'
        $pembayaran->update([
            'status_verifikasi' => 'rejected',
            'keterangan' => $request->alasan_tolak
        ]);

        // 2. Feedback status pendaftaran agar Klien tahu aksi yang harus dilakukan
        $pembayaran->pendaftaran->update([
            'status' => '⚠️ Pembayaran Termin ' . $pembayaran->termin . ' Ditolak: ' . $request->alasan_tolak
        ]);

        return back()->with('success', 'Pembayaran ditolak. Alasan telah dikirim ke klien.');
    }
}
