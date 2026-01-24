<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Dokumen;
use App\Services\PendaftaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    protected $service;

    // Daftar dokumen tetap sama
    private $listDokumen = [
        'nib' => 'NIB (Nomor Induk Berusaha)',
        'surat_permohonan' => 'Surat Permohonan',
        'formulir_pendaftaran' => 'Formulir Pendaftaran',
        'dokumen_penyelia' => 'Dokumen Penyelia Halal (SK & Sertifikat)',
        'manual_sjph' => 'Manual SJPH',
        'izin_edar' => 'Izin Edar (PIRT/MD)'
    ];

    public function __construct(PendaftaranService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('dashboard')->with('error', 'Pendaftaran tidak ditemukan.');
        }

        // KUNCI UTAMA (10 Level): Menu hanya terbuka jika sudah LEVEL 4 (Setelah Plotting Admin)
        if ($pendaftaran->progress_level < 5 || !$pendaftaran->konsultan_id) {
            return redirect()->route('dashboard') // Mengarahkan ke rute 'dashboard' sesuai web.php Anda
                ->with('error', 'Tahap Unggah Dokumen belum tersedia. Menunggu penugasan Konsultan oleh Admin.');
        }

        $dokumenUploaded = Dokumen::where('pendaftaran_id', $pendaftaran->id)
                            ->get()
                            ->keyBy('nama_dokumen')
                            ->toArray();

        return view('klien.proses.dokumen', [
            'pendaftaran' => $pendaftaran,
            'listDokumen' => $this->listDokumen,
            'dokumenUploaded' => $dokumenUploaded
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'file' => 'required|mimes:pdf,jpg,png|max:5120',
        ]);

        // Verifikasi pendaftaran harus Level 4 dan sudah ada Konsultan
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
                        ->where('progress_level', 5)
                        ->whereNotNull('konsultan_id')
                        ->latest()
                        ->first();

        if (!$pendaftaran) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak atau sesi berakhir.');
        }

        $file = $request->file('file');
        $filename = strtoupper($request->jenis) . '_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('dokumen_pendaftaran', $filename, 'local');

        Dokumen::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id, 'nama_dokumen' => $request->jenis],
            [
                'file_path' => $path,
                'status_verifikasi' => 'pending'
            ]
        );

        return redirect()->back()->with('success', 'Dokumen ' . $this->listDokumen[$request->jenis] . ' berhasil diunggah.');
    }

    public function viewFile($path)
    {
        $cleanPath = str_replace('dokumen_pendaftaran/', '', $path);
        $fullPath = 'dokumen_pendaftaran/' . $cleanPath;

        // 2. Cek apakah file ada di disk 'local' (storage/app/dokumen_pendaftaran)
        if (!Storage::disk('local')->exists($fullPath)) {
            // Jika tidak ada, coba cek path mentah tanpa prefix
            if (!Storage::disk('local')->exists($path)) {
                abort(404, 'File fisik tidak ditemukan di server. Silakan unggah ulang.');
            }
            $fullPath = $path;
        }

        // 3. Dapatkan path absolut untuk response file
        $file = Storage::disk('local')->get($path);
        $type = Storage::disk('local')->mimeType($path);

        // 4. Return file secara inline (untuk preview di browser)
        return response($file, 200)->header('Content-Type', $type);
    }

    public function destroy($id)
    {
        $dokumen = Dokumen::where('id', $id)
                    ->whereHas('pendaftaran', function($q) {
                        $q->where('user_id', Auth::id());
                    })->firstOrFail();

        // Hapus file fisik dari storage
        if (Storage::disk('local')->exists($dokumen->file_path)) {
            Storage::disk('local')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
