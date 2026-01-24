<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PendaftaranService;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfilLengkap
{
    protected $pendaftaranService;

    public function __construct(PendaftaranService $service)
    {
        $this->pendaftaranService = $service;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan hanya memeriksa user dengan role 'klien'
        if (Auth::check() && Auth::user()->role === 'klien') {

            // 2. Kecualikan rute profil itu sendiri agar tidak terjadi loop redirect
            // Dan kecualikan rute Logout agar user tetap bisa keluar
            if ($request->routeIs('klien.profil.*') || $request->is('logout')) {
                return $next($request);
            }

            // 3. Cek kelengkapan profil (Level 0)
            if (!$this->pendaftaranService->isProfilLengkap(Auth::id())) {

                // Jika request mengharapkan JSON (misal: pendaftaran via AJAX)
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Lengkapi profil perusahaan Anda.'], 403);
                }

                return redirect()->route('klien.profil.index')
                    ->with('warning', 'Sesuai Prosedur: Anda wajib melengkapi data legalitas perusahaan sebelum memulai pendaftaran.');
            }
        }

        return $next($request);
    }
}
