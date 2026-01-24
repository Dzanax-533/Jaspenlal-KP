<?php

namespace App\Http\Controllers\Klien;

use App\Http\Controllers\Controller;
use App\Models\KlienDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = KlienDetail::where('user_id', Auth::id())->first();
        return view('klien.onboarding.profil-perusahaan', compact('profil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan'   => 'required|string|max:255',
            'npwp'              => 'required|string|max:20',
            'alamat_perusahaan' => 'required|string',
            'skala_usaha'       => 'required|in:mikro,kecil,menengah,besar',
        ]);

        KlienDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only(['nama_perusahaan', 'npwp', 'alamat_perusahaan', 'skala_usaha'])
        );

        return redirect()->route('dashboard')->with('success', 'Profil perusahaan berhasil disimpan. Sekarang Anda dapat memulai pendaftaran.');
    }
}
