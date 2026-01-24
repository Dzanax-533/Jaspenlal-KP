<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BahanController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
                        ->latest()
                        ->firstOrFail();

        if ($pendaftaran->progress_level < 6) {
            return redirect()->route('dashboard')
                ->with('error', 'Tahap Evaluasi Bahan belum tersedia. Pastikan Dokumen Anda sudah divalidasi Konsultan.');
        }

        $bahans = Bahan::where('pendaftaran_id', $pendaftaran->id)->get();

        return view('klien.proses.bahan', compact('pendaftaran', 'bahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'produsen' => 'required|string|max:255',
            'lembaga_penerbit' => 'nullable|string|max:100',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'masa_berlaku' => 'nullable|date',
        ]);

        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
                        ->where('progress_level', 6)
                        ->latest()
                        ->first();

        if (!$pendaftaran) {
            return redirect()->back()->with('error', 'Akses ditolak. Tahap evaluasi bahan belum dimulai atau sudah selesai.');
        }

        Bahan::create([
            'pendaftaran_id'    => $pendaftaran->id,
            'nama_bahan'        => $request->nama_bahan,
            'produsen'          => $request->produsen,
            'lembaga_penerbit'  => $request->lembaga_penerbit,
            'nomor_sertifikat'  => $request->nomor_sertifikat,
            'masa_berlaku'      => $request->masa_berlaku,
            'status_validasi'   => 'pending',
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan ke daftar evaluasi.');
    }

    public function destroy($id)
    {
        $bahan = Bahan::whereHas('pendaftaran', function($q) {
                    $q->where('user_id', Auth::id());
                })->findOrFail($id);

        // SINKRONISASI 10 LEVEL: Proteksi jika pendaftaran sudah naik ke Audit (Lvl 7)
        if ($bahan->pendaftaran->progress_level >= 7) {
            return redirect()->back()->with('error', 'Bahan tidak dapat dihapus karena sudah dalam proses audit lapangan.');
        }

        // Proteksi: Bahan yang sudah 'verified' oleh konsultan tidak boleh dihapus klien
        if ($bahan->status_validasi == 'verified') {
            return redirect()->back()->with('error', 'Bahan yang sudah divalidasi konsultan tidak dapat dihapus.');
        }

        $bahan->delete();
        return redirect()->back()->with('success', 'Bahan berhasil dihapus.');
    }
}
