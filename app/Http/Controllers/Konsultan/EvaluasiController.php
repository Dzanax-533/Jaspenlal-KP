<?php

namespace App\Http\Controllers\Konsultan;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Pendaftaran;
use App\Models\Dokumen;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EvaluasiController extends Controller
{
    protected $service;

    public function __construct(PendaftaranService $service)
    {
        $this->service = $service;
    }

    /**
     * Halaman Daftar Validasi Dokumen (Level 5)
     */
    public function indexDokumen()
    {
        $pendampingans = Pendaftaran::where('konsultan_id', Auth::id())
                        ->where('progress_level', 5)
                        ->with(['user.klienDetail'])
                        ->latest()
                        ->get();

        return view('konsultan.evaluasi.index_dokumen', compact('pendampingans'));
    }

    /**
     * AKSI: Validasi Dokumen per Item (Level 5)
     */
    public function validasiDokumen(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan' => 'nullable|string'
        ]);

        $dokumen = Dokumen::findOrFail($id);
        $pendaftaranId = $dokumen->pendaftaran_id;

        $dokumen->update([
            'status' => $request->status,
            'catatan_revisi' => $request->catatan
        ]);

        // Daftar 6 dokumen wajib yang baru
        $listWajib = [
            'nib', 'surat_permohonan', 'formulir_pendaftaran',
            'dokumen_penyelia', 'manual_sjph', 'izin_edar'
        ];

        // Cek progres: Hanya hitung dokumen yang masuk dalam list wajib saja
        $totalApproved = Dokumen::where('pendaftaran_id', $pendaftaranId)
                                ->whereIn('nama_dokumen', $listWajib)
                                ->where('status', 'approved')
                                ->count();

        if ($totalApproved >= 6) {
            $this->service->updateStep($pendaftaranId, 6, [
                'status' => 'Dokumen Valid. Silakan Melengkapi Daftar Bahan.'
            ]);
            return redirect()->route('konsultan.dashboard')
                ->with('success', 'Seluruh berkas (6/6) approved! Klien kini diminta mengisi daftar bahan (Level 6).');
        }

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    /**
     * Halaman Daftar Evaluasi Bahan (Level 6)
     */
    public function indexBahan()
    {
        $pendampingans = Pendaftaran::where('konsultan_id', Auth::id())
                        ->where('progress_level', 6)
                        ->with(['user.klienDetail', 'bahans'])
                        ->latest()
                        ->get();

        return view('konsultan.evaluasi.index_bahan', compact('pendampingans'));
    }

    /**
     * AKSI: Validasi Bahan & Finalisasi Tahap (Level 6)
     */
    public function validasiBahan(Request $request, $id)
    {

        if ($request->has('final_step')) {
            $pendaftaran = Pendaftaran::findOrFail($id);

            $request->validate([
                'tgl_audit' => 'required|date|after:today',
            ]);

            // Validasi keamanan: Pastikan semua bahan sudah 'verified'
            $totalBahan = $pendaftaran->bahans()->count();
            $totalVerified = $pendaftaran->bahans()->where('status_validasi', 'verified')->count();

            if ($totalBahan === 0) {
                return back()->with('error', 'Klien belum menginputkan daftar bahan.');
            }

            if ($totalBahan !== $totalVerified) {
                return back()->with('error', 'Gagal. Ada bahan yang belum disetujui (Verified).');
            }

            // Naik ke Level 7 (Audit Lapangan)
            $this->service->updateStep($id, 7, [
                'tgl_audit' => $request->tgl_audit,
                'status' => 'Bahan Terverifikasi. Jadwal Audit: ' . \Carbon\Carbon::parse($request->tgl_audit)->format('d/m/Y')
            ]);

            return redirect()->route('konsultan.evaluasi.bahan')->with('success', 'Level 6 Selesai. Jadwal Audit Lapangan telah ditetapkan.');
        }

        // Logika Validasi per Item Bahan
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string'
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->update([
            'status_validasi' => $request->status,
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Status bahan diperbarui.');
    }

    /**
     * Detail Review (Routing Otomatis berdasarkan Progress Level)
     */
    public function showReview($id)
    {
        // Menggunakan Auth::id() memastikan Konsultan hanya bisa melihat tugas miliknya (Menghindari Forbidden 403)
        $pendaftaran = Pendaftaran::with(['user.klienDetail', 'bahans', 'dokumens'])
                        ->where('konsultan_id', Auth::id())
                        ->findOrFail($id);

        // LEVEL 5: Tahap Verifikasi Dokumen
        if ($pendaftaran->progress_level == 5) {
            // SESUAIKAN: Hanya 6 dokumen sesuai diskusi kita tadi
            $listDokumen = [
                'nib' => 'NIB',
                'surat_permohonan' => 'Surat Permohonan',
                'formulir_pendaftaran' => 'Formulir Pendaftaran',
                'dokumen_penyelia' => 'Dokumen Penyelia',
                'manual_sjph' => 'Manual SJPH',
                'izin_edar' => 'Izin Edar'
            ];

            return view('konsultan.evaluasi.berkas', compact('pendaftaran', 'listDokumen'));
        }

        // LEVEL 6: Tahap Evaluasi Bahan
        if ($pendaftaran->progress_level == 6) {
            return view('konsultan.evaluasi.bahan', compact('pendaftaran'));
        }

        // LEVEL 7 KE ATAS: Audit Lapangan
        return redirect()->route('konsultan.audit.index');
    }

    /**
     * Stream File Private
     */
    public function viewFile($id)
    {
        $dokumen = Dokumen::with('pendaftaran')->findOrFail($id);

        if ($dokumen->pendaftaran->konsultan_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        if (!Storage::disk('local')->exists($dokumen->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::disk('local')->get($dokumen->file_path);
        $type = Storage::disk('local')->mimeType($dokumen->file_path);

        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * FINALIZE AUDIT: Level 7 -> 8 (Upload LHA)
     */
    public function finalizeAudit(Request $request, $id)
    {
        $request->validate([
            'file_lha' => 'required|mimes:pdf|max:10240',
            'catatan_audit' => 'nullable|string'
        ]);

        $pendaftaran = Pendaftaran::where('konsultan_id', Auth::id())
                        ->where('progress_level', 7)
                        ->findOrFail($id);

        if ($request->hasFile('file_lha')) {
            $path = $request->file('file_lha')->store('laporan_audit', 'local');

            $this->service->updateStep($pendaftaran->id, 8, [
                'file_lha' => $path,
                'catatan_audit' => $request->catatan_audit,
            ]);

            return redirect()->route('konsultan.dashboard')->with('success', 'LHA Berhasil diunggah. Status: Sidang Fatwa.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }
}
