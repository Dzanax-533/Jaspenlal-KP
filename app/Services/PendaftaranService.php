<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\KlienDetail;
use Exception;

class PendaftaranService
{
    /**
     * FASE 0: Validasi Kelengkapan Profil Perusahaan
     */
    public function isProfilLengkap($userId)
    {
        $profil = KlienDetail::where('user_id', $userId)->first();

        if (!$profil) return false;

        // Cek data wajib sesuai Fase 0
        return !empty($profil->nama_perusahaan) &&
               !empty($profil->npwp) &&
               !empty($profil->alamat_perusahaan) &&
               !empty($profil->skala_usaha);
    }

    /**
     * FASE 1 - 4: Master Logic Progress Level (1-9)
     */
public function updateStep($pendaftaranId, $targetLevel, array $data = [])
    {
        $pendaftaran = Pendaftaran::findOrFail($pendaftaranId);

        $statusMap = [
            1  => 'Menunggu DP',                       // Klien baru daftar, belum bayar
            2  => 'Verifikasi DP',                     // Klien sudah upload bukti, tunggu Tim Keuangan
            3  => 'DP Bermasalah / Ditolak',           // Opsional: Jika keuangan menolak bukti bayar
            4  => 'Antrean Plotting Konsultan',        // Keuangan Approve, Klien masuk list tugas Admin
            5  => 'Unggah Dokumen Persyaratan',        // Admin sudah Assign Konsultan, Gembok Dokumen terbuka
            6  => 'Evaluasi & Daftar Bahan',           // Konsultan mulai review berkas & bahan
            7  => 'Audit Lapangan Berlangsung',        // Konsultan input Tgl Audit
            8  => 'Proses Sidang Fatwa',               // Konsultan upload LHA
            9  => 'Menunggu Pelunasan (40%)',          // Admin upload Ketetapan Halal
            10 => 'Sertifikat Halal Terbit',           // Keuangan verifikasi Pelunasan & Admin upload Sertifikat
        ];

        $pendaftaran->progress_level = $targetLevel;

        if (!isset($data['status']) && isset($statusMap[$targetLevel])) {
            $pendaftaran->status = $statusMap[$targetLevel];
        }

        if (!empty($data)) {
            $pendaftaran->fill($data);
        }

        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Logika Perhitungan Nominal (Termin 1 & 2)
     */
    public function hitungTermin($totalBiaya, $level)
    {
        return ($level <= 2) ? $totalBiaya * 0.6 : $totalBiaya * 0.4;
    }

    public function hitungTotalBiaya($paketId, $totalMenu, $totalOutlet)
    {
        $totalMenu = (int) $totalMenu;
        $totalOutlet = (int) $totalOutlet;
        // Ambil Harga Dasar dari Database berdasarkan ID Paket yang dipilih
        $paket = \App\Models\Paket::find($paketId);

        // Fallback jika paket tidak ditemukan
        if (!$paket) {
            $biayaDasar = 2500000;
            $skalaUsaha = 'silver'; // default
        } else {
            $biayaDasar = $paket->harga;
            $skalaUsaha = strtolower($paket->nama_paket);
        }

        // Tambahan Menu (Per 30 item setelah 50 menu pertama)
        $biayaTambahanMenu = 0;
        if ($totalMenu > 50) {
            // Rate tambahan disesuaikan dengan skala usaha dari nama paket
            $rate = 500000; // default silver

            if (str_contains($skalaUsaha, 'platinum')) {
                $rate = 1500000;
            } elseif (str_contains($skalaUsaha, 'gold')) {
                $rate = 1000000;
            }

            $biayaTambahanMenu = ceil(($totalMenu - 50) / 30) * $rate;
        }

        // Tambahan Fasilitas (Rp 1.500.000 per outlet tambahan setelah outlet pertama)
        $biayaTambahanOutlet = ($totalOutlet > 1) ? ($totalOutlet - 1) * 1500000 : 0;

        return $biayaDasar + $biayaTambahanMenu + $biayaTambahanOutlet;
    }

    public function generateNoPendaftaran()
    {
        $dateCode = now()->format('Ymd');
        $lastRecord = \App\Models\Pendaftaran::whereDate('created_at', now())->latest()->first();
        $nextNumber = $lastRecord ? ((int) substr($lastRecord->no_pendaftaran, -3)) + 1 : 1;

        return 'REG-' . $dateCode . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}
