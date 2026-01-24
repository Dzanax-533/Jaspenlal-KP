<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            background-color: #10b981;
            border: none;
            color: white;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #064e3b; text-align: center;">Sertifikat Halal Terbit!</h2>
        <p>Halo, <strong>{{ $pendaftaran->user->name }}</strong>,</p>
        <p>Kabar gembira! Proses sertifikasi halal untuk nomor pendaftaran <strong>{{ $pendaftaran->no_pendaftaran }}</strong> telah selesai.</p>
        <p>Sertifikat Anda kini sudah tersedia dan dapat diunduh melalui dashboard sistem.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('klien.sertifikat.index') }}" class="button" style="color: white;">Buka Dashboard Sertifikat</a>
        </div>

        <p>Terima kasih telah menggunakan layanan kami.</p>
        <hr style="border: none; border-top: 1px solid #eee;">
        <p style="font-size: 0.8rem; color: #777; text-align: center;">
            Email ini dikirim otomatis oleh Sistem Sertifikasi Halal. Harap tidak membalas email ini.
        </p>
    </div>
</body>
</html>
