<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Services\PendaftaranService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    protected $service;

    public function __construct(PendaftaranService $service) {
        $this->service = $service;
    }

    public function invoice($id)
    {
        $pendaftaran = Pendaftaran::with(['paket', 'pembayarans'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($pendaftaran->progress_level <= 2) {
            // Fase Awal: Pembayaran DP
            $termin = 1;
        } elseif ($pendaftaran->progress_level >= 9) {
            // Fase Akhir: Pembayaran Pelunasan
            $termin = 2;
        } else {
            // Fase Tengah (Lvl 3 s/d 8): Belum saatnya pelunasan
            // Set ke termin 1 agar yang tampil di halaman invoice adalah data DP-nya
            $termin = 1;
        }

        // Ambil nominal berdasarkan termin yang ditentukan di atas
        $nominal = $this->service->hitungTermin($pendaftaran->total_biaya, $termin);

        // Ambil data pembayaran terakhir untuk termin tersebut (jika ada)
        $pembayaranSaatIni = $pendaftaran->pembayarans
            ->where('termin', (string)$termin)
            ->sortByDesc('created_at')
            ->first();

        return view('klien.transaksi.invoice', compact(
            'pendaftaran', 'termin', 'nominal', 'pembayaranSaatIni'
        ));
    }

    public function storeBayar(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nominal'        => 'required|numeric',
            'termin'         => 'required|in:1,2'
        ]);

        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->findOrFail($id);

        // Proteksi: Cek status verifikasi saat ini
        $cekBukti = $pendaftaran->pembayarans()
            ->where('termin', $request->termin)
            ->whereIn('status_verifikasi', ['pending', 'verified'])
            ->first();

        if ($cekBukti) {
            return back()->with('warning', 'Pembayaran termin ini sudah dikirim atau sudah diverifikasi.');
        }

        if ($request->hasFile('bukti_transfer')) {
            try {
                $file = $request->file('bukti_transfer');

                // Penamaan file
                $filename = 'BUKTI_T' . $request->termin . '_' . $pendaftaran->no_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

                // Simpan ke tabel pembayarans
                $pendaftaran->pembayarans()->create([
                    'termin'            => $request->termin,
                    'nominal'           => $request->nominal,
                    'bukti_transfer'    => $path,
                    'status_verifikasi' => 'pending',
                    'keterangan'        => 'Bukti transfer diunggah oleh klien.'
                ]);

                // Update status pendaftaran (Tetap di level yang sama sampai diverifikasi Keuangan)
                $pendaftaran->update([
                    'status' => ($request->termin == 1) ? 'Verifikasi DP' : 'Verifikasi Pelunasan'
                ]);

                return redirect()->route('dashboard')->with('success', 'Bukti transfer berhasil dikirim! Silakan tunggu verifikasi Keuangan.');

            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses unggahan: ' . $e->getMessage());
            }
        }
        return back()->with('error', 'File tidak ditemukan.');
    }

    public function downloadPdf($id)
    {
        $pendaftaran = Pendaftaran::with(['user.klienDetail', 'paket'])->findOrFail($id);

        // Memanggil view yang akan kita buat di langkah ke-3
        $pdf = Pdf::loadView('klien.pdf.invoice', compact('pendaftaran'));

        // Mengunduh file dengan nama spesifik
        return $pdf->download('Invoice-' . $pendaftaran->no_pendaftaran . '.pdf');
    }
}
