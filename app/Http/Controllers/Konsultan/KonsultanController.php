<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultanController extends Controller
{
    protected $service;

    public function __construct(PendaftaranService $service)
    {
        $this->service = $service;
    }

    /**
     * Dashboard Utama
     */
    public function index()
    {
        $konsultanId = Auth::id();
        $userId = auth()->id();

        // Mengambil tugas aktif (Level 4 - 7)
        $pendampingans = Pendaftaran::with(['user.klienDetail', 'paket'])
            ->where('konsultan_id', $konsultanId)
            ->whereIn('progress_level', [4, 5, 6, 7])
            ->latest()
            ->get();

        $tugas = Pendaftaran::with(['user.klienDetail', 'paket'])
            ->where('konsultan_id', $userId)
            ->whereIn('progress_level', [4, 5, 6, 7])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik untuk widget dashboard
        $stats = [
            'total_tugas'      => Pendaftaran::where('konsultan_id', $konsultanId)->whereIn('progress_level', [4, 5, 6, 7])->count(),
            'perlu_verifikasi'   => Pendaftaran::where('konsultan_id', $konsultanId)->where('progress_level', 5)->count(),
            'evaluasi_bahan'   => Pendaftaran::where('konsultan_id', $konsultanId)->where('progress_level', 6)->count(),
            'siap_audit'       => Pendaftaran::where('konsultan_id', $konsultanId)->where('progress_level', 7)->count(),
        ];

        return view('konsultan.dashboard', compact('stats', 'pendampingans', 'tugas'));
    }

    /**
     * ANTREAN AUDIT (Level 7)
     */
    public function listAudit()
    {
        $pendampingans = Pendaftaran::with(['user.klienDetail'])
            ->where('konsultan_id', Auth::id())
            ->where('progress_level', 7)
            ->orderBy('tgl_audit', 'asc')
            ->get();

        return view('konsultan.audit.index', compact('pendampingans'));
    }

    /**
     * FORM INPUT LHA
     */
    public function formAudit($id)
    {
        $pendaftaran = Pendaftaran::where('konsultan_id', Auth::id())
                        ->where('progress_level', 7)
                        ->findOrFail($id);

        return view('konsultan.audit.form', compact('pendaftaran'));
    }

    /**
     * SIMPAN LHA & NAIK KE LEVEL 8
     */
    public function uploadLHA(Request $request, $id)
    {
        $request->validate([
            'file_lha' => 'required|mimes:pdf|max:10240',
            'catatan_audit' => 'nullable|string'
        ]);

        $pendaftaran = Pendaftaran::where('konsultan_id', Auth::id())
                        ->where('progress_level', 7)
                        ->findOrFail($id);

        if ($request->hasFile('file_lha')) {
            // Gunakan disk 'local' agar tersimpan di storage/app/laporan_audit (Private)
            $path = $request->file('file_lha')->store('laporan_audit', 'local');

            // Update ke Level 8 via Service
            $this->service->updateStep($pendaftaran->id, 8, [
                'file_lha' => $path,
                'catatan_audit' => $request->catatan_audit,
            ]);

            return redirect()->route('konsultan.audit.index')
                ->with('success', 'Laporan Hasil Audit (LHA) berhasil diunggah. Status otomatis naik ke Sidang Fatwa (Level 8).');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }
}
