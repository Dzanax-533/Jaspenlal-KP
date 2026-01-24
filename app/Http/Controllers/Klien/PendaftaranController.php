<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\Pendaftaran;
use App\Services\PendaftaranService;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $service) {
        $this->pendaftaranService = $service;
    }

    public function create()
    {
        $user = Auth::user();
        $skalaUsaha = $user->klienDetail->skala_usaha ?? 'mikro';

        // Cek apakah user punya pendaftaran yang statusnya BUKAN 'selesai'
        $pendaftaranAktif = Pendaftaran::where('user_id', $user->id)
            ->where('progress_level', '<', 10)
            ->first();

        if ($pendaftaranAktif) {
            // Jika ada yang masih aktif, arahkan ke invoice pendaftaran tersebut
            return redirect()->route('klien.transaksi.invoice', $pendaftaranAktif->id)
                ->with('warning', 'Anda masih memiliki pendaftaran yang sedang berjalan. Silakan selesaikan pembayaran atau proses tersebut terlebih dahulu.');
        }

        // Jika tidak ada pendaftaran aktif, tampilkan form pendaftaran baru
        $pakets = Paket::all();
        return view('klien.pendaftaran.create', compact('pakets','skalaUsaha'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required',
            'total_menu' => 'required|numeric',
            'total_outlet' => 'required|numeric',
        ]);

        try {
            $user = Auth::user();

            // 1. GUNAKAN SERVICE UNTUK HITUNG TOTAL BIAYA
            $totalBiaya = $this->pendaftaranService->hitungTotalBiaya(
                $request->paket_id,
                $request->total_menu,
                $request->total_outlet
            );

            // 2. SIMPAN KE DATABASE
            $pendaftaran = Pendaftaran::create([
                'user_id'           => $user->id,
                'paket_id'          => $request->paket_id,
                'no_pendaftaran'    => $this->pendaftaranService->generateNoPendaftaran(),
                'total_menu'        => $request->total_menu,
                'total_outlet'      => $request->total_outlet,
                'luar_jabodetabek'  => $request->has('luar_jabodetabek'),
                'total_biaya'       => $totalBiaya,
                'progress_level'    => 1,
                'status'            => 'Menunggu DP', 
            ]);

            // 3. KIRIM WHATSAPP
            $pesanTagihan = "📄 *TAGIHAN PENDAFTARAN*\n\n";
            $pesanTagihan .= "Halo " . $user->name . ",\n";
            $pesanTagihan .= "Pendaftaran Anda dengan nomor *" . $pendaftaran->no_pendaftaran . "* telah berhasil dibuat.\n\n";
            $pesanTagihan .= "Total Tagihan: *Rp " . number_format($totalBiaya, 0, ',', '.') . "*\n";
            $pesanTagihan .= "Silakan lakukan pembayaran DP 60% untuk memulai proses audit.\n\n";
            $pesanTagihan .= "Cek rincian invoice di dashboard Anda.";

            // Pastikan nama kolom no hp di User/KlienDetail sesuai (disini saya pakai no_telepon sesuai Model User Anda)
            \App\Services\WhatsappService::sendMessage($user->no_telepon, $pesanTagihan);

            return redirect()->route('klien.transaksi.invoice', $pendaftaran->id);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function sertifikat()
    {
        $pendaftaranSelesai = Pendaftaran::where('user_id', auth()->id())
                            ->where('progress_level', 10)
                            ->whereNotNull('file_sertifikat')
                            ->get();

        return view('klien.sertifikat.index', compact('pendaftaranSelesai'));
    }
}
