<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: right; margin-bottom: 30px; border-bottom: 2px solid #10b981; padding-bottom: 10px; }
        .header h2 { color: #10b981; margin: 0; }
        .info-table { width: 100%; margin-bottom: 30px; }
        .info-table td { vertical-align: top; width: 50%; }
        .table-items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table-items th { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px; text-align: left; }
        .table-items td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        .text-right { text-align: right; }
        .total-section { margin-top: 30px; float: right; width: 300px; }
        .total-row { padding: 8px 0; border-bottom: 1px solid #eee; }
        .grand-total { font-size: 16px; font-weight: bold; color: #10b981; padding: 10px 0; }
        .footer { margin-top: 50px; font-size: 10px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE TAGIHAN</h2>
        <p>No: {{ $pendaftaran->no_pendaftaran }}<br>Tanggal: {{ $pendaftaran->created_at->format('d/m/Y') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <strong>Penerima:</strong><br>
                {{ $pendaftaran->user->name }}<br>
                {{ $pendaftaran->user->klienDetail->nama_perusahaan }}<br>
                {{ $pendaftaran->user->klienDetail->alamat_perusahaan }}
            </td>
            <td class="text-right">
                <strong>Status:</strong><br>
                <span style="color: orange;">{{ $pendaftaran->status }}</span>
            </td>
        </tr>
    </table>

    <table class="table-items">
        <thead>
            <tr>
                <th>Deskripsi Layanan</th>
                <th class="text-right">Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Paket {{ $pendaftaran->paket->nama_paket }}</strong><br>
                    <small>Skala Usaha: {{ ucfirst($pendaftaran->user->klienDetail->skala_usaha) }}</small>
                </td>
                <td class="text-right">Rp {{ number_format($pendaftaran->biaya_dasar, 0, ',', '.') }}</td>
            </tr>
            @if($pendaftaran->biaya_menu_tambahan > 0)
            <tr>
                <td>
                    <strong>Tambahan Produk/Menu</strong><br>
                    <small>Kapasitas: {{ $pendaftaran->total_menu }} Produk</small>
                </td>
                <td class="text-right">Rp {{ number_format($pendaftaran->biaya_menu_tambahan, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($pendaftaran->biaya_outlet_tambahan > 0)
            <tr>
                <td>
                    <strong>Tambahan Outlet/Fasilitas</strong><br>
                    <small>Total: {{ $pendaftaran->total_outlet }} Outlet</small>
                </td>
                <td class="text-right">Rp {{ number_format($pendaftaran->biaya_outlet_tambahan, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Total Kontrak:</span>
            <span style="float: right;">Rp {{ number_format($pendaftaran->total_biaya, 0, ',', '.') }}</span>
        </div>
        <div class="grand-total">
            <span>DP 60% (Wajib):</span>
            <span style="float: right;">Rp {{ number_format($pendaftaran->total_biaya * 0.6, 0, ',', '.') }}</span>
        </div>
        <p style="font-size: 9px; color: #666;">*Pembayaran DP diperlukan untuk aktivasi proses pendampingan.</p>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Invoice ini dihasilkan secara otomatis oleh Sistem Sertifikasi Halal.<br>Pembayaran dilakukan melalui nomor rekening yang tertera di dashboard klien.</p>
    </div>
</body>
</html>
