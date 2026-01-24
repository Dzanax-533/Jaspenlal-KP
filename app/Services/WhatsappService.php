<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    /**
     * Mengirim pesan WhatsApp menggunakan API Fonnte
     */
    public static function sendMessage($target, $message)
    {
        // Mengambil token dari file .env
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'countryCode' => '62', // Otomatis tambah 62 jika nomor diawali 08
        ]);

        return $response->json();
    }
}
