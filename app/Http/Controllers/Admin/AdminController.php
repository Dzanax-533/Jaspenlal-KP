<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Services\PendaftaranService;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use App\Mail\SertifikatTerbitMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected $service;

    public function __construct(PendaftaranService $service) {
        $this->service = $service;
    }

    public function index() {
        $users = User::latest()->paginate(10);

        $stats = [
            'total_klien'        => User::where('role', 'klien')->count(),
            'total_ditolak'      => Pendaftaran::where('status', 'Ditolak')->count(),
            'pending_plotting'   => Pendaftaran::where('progress_level', 4)->count(),
            'pending_sidang'     => Pendaftaran::where('progress_level', 8)->count(),
            'pending_pelunasan'  => Pendaftaran::where('progress_level', 9)->count(),
            'pending_sertifikat' => Pendaftaran::where('progress_level', 10)->count(),
        ];

        $pendaftaranTerbaru = Pendaftaran::with('user')
            ->whereIn('progress_level', [4])
            ->where('status', '!=', 'Ditolak')
            ->latest()
            ->take(5)
            ->get();

        // Data ini yang menyebabkan error karena tidak dikirim ke view
        $konsultans = User::where('role', 'konsultan')->get();

        $logPenolakan = Pendaftaran::with('user')
            ->where('status', 'Ditolak')
            ->latest()
            ->take(5)
            ->get();

        // Perbaikan: Tambahkan 'konsultans' ke dalam compact
        return view('admin.dashboard', compact(
            'stats',
            'pendaftaranTerbaru',
            'logPenolakan',
            'konsultans'
        ));
    }

    // --- LEVEL 3: PLOTTING ---
    public function indexPlotting() {
        $data = Pendaftaran::with(['user', 'klienDetail'])
                ->where('progress_level', 4)
                ->latest()
                ->get();
        $konsultans = User::where('role', 'konsultan')
                ->withCount(['pendampingans' => function($query) {
                    $query->where('progress_level', '<', 10);
                }])
                ->get();
        return view('admin.operasional.plotting', compact('data', 'konsultans'));
    }

    public function assignKonsultan(Request $request) {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'konsultan_id' => 'required|exists:users,id'
        ]);

        try {
            $this->service->updateStep($request->pendaftaran_id, 5, [
                'konsultan_id' => $request->konsultan_id,
            ]);
            return back()->with('success', 'Konsultan berhasil ditugaskan! Klien kini bisa akses menu Dokumen.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // --- LEVEL 8: SIDANG FATWA ---
    public function indexSidang() {
        $data = Pendaftaran::with(['user', 'konsultan'])
                ->where('progress_level', 8)
                ->latest()
                ->get();
        return view('admin.sidang.index', compact('data'));
    }

    public function uploadKetetapan(Request $request, $id) {
        $request->validate([
            'file_ketetapan_halal' => 'required|mimes:pdf|max:5120',
            'tgl_sidang' => 'required|date'
        ]);

        $path = $request->file('file_ketetapan_halal')->store('ketetapan_halal', 'public');

        $this->service->updateStep($id, 9, [
            'file_ketetapan_halal' => $path,
            'tgl_sidang' => $request->tgl_sidang
        ]);

        return back()->with('success', 'Ketetapan Halal diunggah. Pendaftaran berlanjut ke Tahap Pelunasan (Level 9).');
    }

    // --- LEVEL 10: PENERBITAN SERTIFIKAT ---
    public function indexPenerbitan() {
        // PERBAIKAN: Memastikan filter hanya yang benar-benar siap terbit
        $data = Pendaftaran::with('user')
                ->where('progress_level', 10)
                ->latest()
                ->get();
        return view('admin.sertifikat.index', compact('data'));
    }

    public function uploadSertifikatFinal(Request $request, $id)
    {
        $request->validate([
            'file_sertifikat' => 'required|mimes:pdf|max:10240'
        ]);

        // Simpan ke disk public agar bisa diakses via symlink storage
        $path = $request->file('file_sertifikat')->store('sertifikat_final', 'public');

        try {
            $this->service->updateStep($id, 10, [
                'file_sertifikat' => $path,
                'status' => 'Sertifikat Terbit - Selesai'
            ]);

        $pendaftaran = \App\Models\Pendaftaran::with('user.klienDetail')->findOrFail($id);
        $nomorWa = $pendaftaran->user->klienDetail->no_hp; // Pastikan kolom ini ada di database

        $pesan = "🔔 *PEMBERITAHUAN SERTIFIKAT HALAL*\n\n";
        $pesan .= "Halo *" . $pendaftaran->user->name . "*,\n\n";
        $pesan .= "Selamat! Sertifikat Halal untuk pendaftaran *" . $pendaftaran->no_pendaftaran . "* telah terbit.\n\n";
        $pesan .= "Silakan unduh sertifikat asli Anda di dashboard sistem pada menu 'Sertifikat'.\n\n";
        $pesan .= "Terima kasih telah mempercayai kami sebagai mitra pendampingan halal Anda. 🙏";

        // Kirim WA
        WhatsappService::sendMessage($nomorWa, $pesan);

            return back()->with('success', 'Sertifikat terbit dan notifikasi WA telah dikirim.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function tolakPendaftaran(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status' => 'Ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
