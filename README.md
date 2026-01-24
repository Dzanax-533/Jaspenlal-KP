<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


```
JASPENLAL
├─ .editorconfig
├─ app
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Admin
│  │  │  │  ├─ AdminController.php
│  │  │  │  └─ UserController.php
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ Keuangan
│  │  │  │  └─ KeuanganController.php
│  │  │  ├─ Klien
│  │  │  │  ├─ BahanController.php
│  │  │  │  ├─ DokumenController.php
│  │  │  │  ├─ PendaftaranController.php
│  │  │  │  ├─ ProfilController.php
│  │  │  │  └─ TransaksiController.php
│  │  │  ├─ Konsultan
│  │  │  │  ├─ EvaluasiController.php
│  │  │  │  └─ KonsultanController.php
│  │  │  └─ ProfileController.php
│  │  ├─ Middleware
│  │  │  ├─ EnsureProfilLengkap.php
│  │  │  └─ RoleMiddleware.php
│  │  └─ Requests
│  │     ├─ Auth
│  │     │  └─ LoginRequest.php
│  │     └─ ProfileUpdateRequest.php
│  ├─ Livewire
│  │  └─ PendaftaranProgress.php
│  ├─ Models
│  │  ├─ Bahan.php
│  │  ├─ Dokumen.php
│  │  ├─ KlienDetail.php
│  │  ├─ Paket.php
│  │  ├─ Pembayaran.php
│  │  ├─ Pendaftaran.php
│  │  ├─ Transaksi.php
│  │  └─ User.php
│  ├─ Providers
│  │  └─ AppServiceProvider.php
│  ├─ Services
│  │  ├─ EvaluasiService.php
│  │  ├─ KeuanganService.php
│  │  └─ PendaftaranService.php
│  └─ View
│     └─ Components
│        ├─ AppLayout.php
│        └─ GuestLayout.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_01_07_084716_create_pakets_table.php
│  │  ├─ 2026_01_07_084717_create_pendaftarans_table.php
│  │  ├─ 2026_01_07_084750_create_pembayarans_table.php
│  │  ├─ 2026_01_07_092449_create_klien_details_table.php
│  │  ├─ 2026_01_07_133138_add_progress_level_to_pendaftarans.php
│  │  ├─ 2026_01_08_151306_create_bahans_table.php
│  │  ├─ 2026_01_08_154115_add_konsultan_id_to_pendaftarans_table.php
│  │  ├─ 2026_01_08_183602_add_file_sertifikat_to_pendaftarans.php
│  │  ├─ 2026_01_08_185126_update_pendaftaran_document_fields.php
│  │  ├─ 2026_01_08_191402_change_status_column_length_in_pendaftarans.php
│  │  ├─ 2026_01_10_210731_finalize_pendaftarans_table.php
│  │  ├─ 2026_01_10_213351_create_dokumens_table.php
│  │  ├─ 2026_01_10_214231_add_lha_to_pendaftarans_table.php
│  │  ├─ 2026_01_10_214754_add_sidang_fatwa_to_pendaftarans.php
│  │  ├─ 2026_01_14_153510_add_alasan_penolakan_to_pendaftarans_table.php
│  │  └─ 2026_01_18_042657_add_validation_to_bahans_table.php
│  └─ seeders
│     ├─ DatabaseSeeder.php
│     ├─ PaketSeeder.php
│     └─ UserSeeder.php
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ img
│  │  └─ logo-khi.png
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  └─ app.css
│  ├─ js
│  │  ├─ app.js
│  │  └─ bootstrap.js
│  └─ views
│     ├─ admin
│     │  ├─ dashboard.blade.php
│     │  ├─ operasional
│     │  │  └─ plotting.blade.php
│     │  ├─ paket
│     │  │  └─ index.blade.php
│     │  ├─ penugasan
│     │  │  └─ index.blade.php
│     │  ├─ sertifikat
│     │  │  └─ index.blade.php
│     │  ├─ sidang
│     │  │  └─ index.blade.php
│     │  └─ users
│     │     ├─ index.blade.php
│     │     ├─ modal-create.blade.php
│     │     └─ modal-edit.blade.php
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ components
│     │  ├─ alert.blade.php
│     │  ├─ application-logo.blade.php
│     │  ├─ auth-session-status.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ dropdown-link.blade.php
│     │  ├─ dropdown.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal-konfirmasi.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ nav-link.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ responsive-nav-link.blade.php
│     │  ├─ secondary-button.blade.php
│     │  ├─ sidebar-link-item.blade.php
│     │  ├─ step-wizard.blade.php
│     │  └─ text-input.blade.php
│     ├─ dashboard.blade.php
│     ├─ keuangan
│     │  ├─ dashboard.blade.php
│     │  ├─ invoice
│     │  │  └─ show.blade.php
│     │  ├─ laporan
│     │  │  └─ index.blade.php
│     │  └─ verifikasi
│     │     ├─ termin1.blade.php
│     │     └─ termin2.blade.php
│     ├─ klien
│     │  ├─ dashboard.blade.php
│     │  ├─ monitoring
│     │  │  └─ progress.blade.php
│     │  ├─ onboarding
│     │  │  └─ profil-perusahaan.blade.php
│     │  ├─ pendaftaran
│     │  │  ├─ create.blade.php
│     │  │  └─ index.blade.php
│     │  ├─ proses
│     │  │  ├─ bahan.blade.php
│     │  │  └─ dokumen.blade.php
│     │  ├─ sertifikat
│     │  │  └─ index.blade.php
│     │  └─ transaksi
│     │     ├─ invoice.blade.php
│     │     └─ upload-bukti.blade.php
│     ├─ konsultan
│     │  ├─ audit
│     │  │  ├─ form.blade.php
│     │  │  ├─ index.blade.php
│     │  │  └─ lph-upload.blade.php
│     │  ├─ dashboard.blade.php
│     │  └─ evaluasi
│     │     ├─ bahan.blade.php
│     │     ├─ berkas.blade.php
│     │     ├─ index_bahan.blade.php
│     │     └─ index_dokumen.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ guest.blade.php
│     │  ├─ navigation.blade.php
│     │  └─ partials
│     │     ├─ nav-admin.blade.php
│     │     ├─ nav-keuangan.blade.php
│     │     ├─ nav-klien.blade.php
│     │     ├─ nav-konsultan.blade.php
│     │     ├─ navbar-top.blade.php
│     │     └─ timeline-klien.blade.php
│     ├─ livewire
│     │  └─ pendaftaran-progress.blade.php
│     ├─ profile
│     │  ├─ edit.blade.php
│     │  └─ partials
│     │     ├─ delete-user-form.blade.php
│     │     ├─ update-password-form.blade.php
│     │     └─ update-profile-information-form.blade.php
│     └─ welcome.blade.php
├─ routes
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ storage
│  ├─ app
│  │  ├─ private
│  │  │  ├─ dokumen_pendaftaran
│  │  │  │  ├─ ASPEK_LEGAL_1768484254_2.png
│  │  │  │  ├─ ASPEK_LEGAL_1768713549_2.jpg
│  │  │  │  ├─ DAFTAR_PRODUK_1768713616_2.png
│  │  │  │  ├─ DOKUMEN_PENYELIA_1768486714_2.png
│  │  │  │  ├─ DOKUMEN_PENYELIA_1768713560_2.jpg
│  │  │  │  ├─ DOKUMEN_PENYELIA_1768753935_5.png
│  │  │  │  ├─ FORMULIR_PENDAFTARAN_1768484233_2.png
│  │  │  │  ├─ FORMULIR_PENDAFTARAN_1768713540_2.jpg
│  │  │  │  ├─ FORMULIR_PENDAFTARAN_1768753637_5.pdf
│  │  │  │  ├─ IZIN_EDAR_1768714240_2.png
│  │  │  │  ├─ IZIN_EDAR_1768752955_5.jpg
│  │  │  │  ├─ MANUAL_SJPH_1768714229_2.png
│  │  │  │  ├─ MANUAL_SJPH_1768753944_5.jpg
│  │  │  │  ├─ MATRIKS_PRODUK_1768713769_2.png
│  │  │  │  ├─ NIB_1768338397_5.png
│  │  │  │  ├─ NIB_1768338401_5.png
│  │  │  │  ├─ NIB_1768483835_2.png
│  │  │  │  ├─ NIB_1768711642_2.pdf
│  │  │  │  ├─ NIB_1768713069_2.pdf
│  │  │  │  ├─ NIB_1768752737_5.pdf
│  │  │  │  ├─ SURAT_PERMOHONAN_1768338512_5.png
│  │  │  │  ├─ SURAT_PERMOHONAN_1768483880_2.png
│  │  │  │  ├─ SURAT_PERMOHONAN_1768713529_2.pdf
│  │  │  │  └─ SURAT_PERMOHONAN_1768752939_5.pdf
│  │  │  ├─ laporan_audit
│  │  │  │  ├─ KEejBnZbU9zCV873inDgHN04I5K3C0VAonRIUShf.pdf
│  │  │  │  └─ TDzIsuwpU20vLiicati00NMs1ZTtgOzWQjzLq8e3.pdf
│  │  │  └─ public
│  │  │     └─ dokumen
│  │  │        ├─ DAFTAR_BAHAN_1767898852_5.png
│  │  │        ├─ DAFTAR_PRODUK_1767898847_5.png
│  │  │        ├─ DIAGRAM_ALIR_1767898858_5.png
│  │  │        ├─ FASILITAS_PABRIK_1767898838_5.png
│  │  │        ├─ FORMULIR_PENDAFTARAN_1767898830_5.png
│  │  │        ├─ MANUAL_SJH_1767898863_5.png
│  │  │        ├─ NIB_1767898825_5.png
│  │  │        ├─ PENYELIA_HALAL_1767898834_5.png
│  │  │        └─ SURAT_PERMOHONAN_1767898767_5.png
│  │  └─ public
│  │     ├─ bukti_pembayaran
│  │     │  ├─ BUKTI_T1_REG-20260111-001_1768147688.jpg
│  │     │  ├─ BUKTI_T1_REG-20260111-001_MUIS_NURYANA_1768143561.jpg
│  │     │  ├─ BUKTI_T1_REG-20260113-001_1768290158.jpg
│  │     │  ├─ BUKTI_T1_REG-20260113-002_1768300571.jpg
│  │     │  ├─ BUKTI_T1_REG-20260113-003_1768301887.jpg
│  │     │  ├─ BUKTI_T1_REG-20260115-001_1768483730.png
│  │     │  ├─ BUKTI_T1_REG-20260116-001_1768571898.jpeg
│  │     │  ├─ BUKTI_T1_REG-20260116-001_1768577268.jpeg
│  │     │  ├─ BUKTI_T1_REG-20260117-001_1768624921.jpeg
│  │     │  ├─ BUKTI_T1_REG-20260118-001_1768740534.jpeg
│  │     │  ├─ BUKTI_T1_REG-J8ZM4XTE_1768330216.png
│  │     │  ├─ BUKTI_T2_REG-20260111-001_MUIS_NURYANA_1768145068.jpg
│  │     │  ├─ BUKTI_T2_REG-20260117-001_1768724565.jpeg
│  │     │  └─ BUKTI_T2_REG-20260118-001_1768755563.jpeg
│  │     ├─ bukti_transfer
│  │     │  ├─ BUKTI_REG-1768086962_1768089656.jpg
│  │     │  ├─ BUKTI_REG-1768086962_1768089928.jpg
│  │     │  └─ BUKTI_REG-1768086962_1768089940.jpg
│  │     ├─ dokumen
│  │     │  ├─ DAFTAR_BAHAN_1767987612_1.jpg
│  │     │  ├─ DAFTAR_PRODUK_1767987604_1.jpg
│  │     │  ├─ DIAGRAM_ALIR_1767987621_1.pdf
│  │     │  ├─ FASILITAS_PABRIK_1767987597_1.jpg
│  │     │  ├─ FORMULIR_PENDAFTARAN_1767987573_1.jpg
│  │     │  ├─ MANUAL_SJH_1767987630_1.pdf
│  │     │  ├─ NIB_1767987584_1.jpg
│  │     │  ├─ PENYELIA_HALAL_1767987590_1.jpg
│  │     │  └─ SURAT_PERMOHONAN_1767987566_1.jpg
│  │     ├─ dokumen_pendaftaran
│  │     │  ├─ ADmxbaf0vnXeYuKIRsDmbfx6Vw3JdTw3rtZ4xQDS.pdf
│  │     │  ├─ GdGTogsZ7MGLMr96GJTIvsD6mT0s2n8FSSm39zXE.pdf
│  │     │  ├─ mOUcFccWBKfKMHskMqEXtOYwiCRwf5fgwxPkKIzO.pdf
│  │     │  └─ uV0wn8l6crO4fxCWdvr1hknU4U0RV4acNdGcL4w4.pdf
│  │     ├─ ketetapan_halal
│  │     │  ├─ se42JMF3Znie2uIeHwmlLpP5ZmAErLKE55Lx09M2.pdf
│  │     │  └─ sGvcmYkpa4cPSnkPVNh64bGJGjuhURZ2GGdXkvh7.pdf
│  │     └─ sertifikat_final
│  │        ├─ 6kAEqjwBIwiJ1ytOYhp2NTCu5sRrtBE21x0KZv5W.pdf
│  │        ├─ 7k3nbrvnoC9XHy1gpi6GNoLzvGHuOOYTDX6Ut53K.pdf
│  │        ├─ m9Mxu0d8obiVUJSMwQ57dqFiAvsSZWsUxkFzRlzL.pdf
│  │        ├─ Rjsw2oRUb9tXiVxaPWsXRnbynhgKsgZzPIe2ItS5.pdf
│  │        └─ RRffPxkj8hGEWjTmfcngcdjs43rgKviXR9hMPaEC.pdf
│  ├─ framework
│  │  ├─ cache
│  │  │  └─ data
│  │  ├─ sessions
│  │  ├─ testing
│  │  └─ views
│  │     ├─ 000b38ae2435e46bdcb901e70991fd4e.php
│  │     ├─ 01605665c866599340a0ef4f6cfa09fd.php
│  │     ├─ 04551c595239b8b04b250d3f785767d8.php
│  │     ├─ 04cc4d9f231ba93d7bb424b3c7c56137.php
│  │     ├─ 05723d98e01d1d0115f2dd326ccaf66f.php
│  │     ├─ 075787ebda105f08faeeb0b37464d462.php
│  │     ├─ 07816cd47ea1d52dc6e86d547789d52d.php
│  │     ├─ 0b44c44728e683e71991a12373d1e966.php
│  │     ├─ 0bd165db34d6b25a6dcc9ff062870e45.php
│  │     ├─ 0d4a25e5160b63befb150debd1a78a68.php
│  │     ├─ 0fe825ee3bf4f3b383ee8af9301ac6d2.php
│  │     ├─ 107ae6275e16c45cec1df6c6c2652537.php
│  │     ├─ 10c8fb1567859c9f5ec082630e838cce.php
│  │     ├─ 13b2deca93d85ad3f1a5415255d74729.php
│  │     ├─ 1659b3bd1b6f87859165da8e4659b277.php
│  │     ├─ 1672b82e7a2061d0864b1f5b35f1095b.php
│  │     ├─ 16db3d9390b0bf4c8d80108511781740.php
│  │     ├─ 1c6f7d23715d9dae756a701730450044.php
│  │     ├─ 1dd341bb9de061f97937a7690fb05b73.php
│  │     ├─ 1eb99b88f2daad98caba8157c87b5de2.php
│  │     ├─ 1fc345df46c38d0592312463233062d9.php
│  │     ├─ 20a02c428688f02f3568596ac62c76a2.php
│  │     ├─ 20c41dc751575ffa67f8121c7384a3ce.php
│  │     ├─ 22065f8e02db09a606c003e0d83047b7.php
│  │     ├─ 2215cd66f6e30e48d939e2972e7a0774.php
│  │     ├─ 24a3613c581e9ab0cd7a4bc320dd23d4.php
│  │     ├─ 24ef83eef1aecb8dd6410702d0c96b05.php
│  │     ├─ 25baa61862bf68c0d250847370cc2e2b.php
│  │     ├─ 27035d3fd3a7f12ea2063c02718ea71a.php
│  │     ├─ 2711aa3762d0ac147e43d541c73f51a0.php
│  │     ├─ 27cdb849d4b6895fe41713d6aa381dfb.php
│  │     ├─ 28caf5b583641212eb17b2be710dbdda.php
│  │     ├─ 292dc16a0c4cfbc1ef22b0d16815a356.php
│  │     ├─ 297132fd226adef27333a9d569f66c8e.php
│  │     ├─ 29b408ba0b0a51767c3a128310448450.php
│  │     ├─ 2ac1050d61f00a7c598d7bc09081179c.php
│  │     ├─ 2c189d9a1c27c82cd80c86c76138071a.php
│  │     ├─ 2c2cda97b7e7cd7006d99dbac1555c46.php
│  │     ├─ 3158d8b9ad36e4d2e86868ee2d7a3304.php
│  │     ├─ 331379f73d4badbfc2637bfa608a6db0.php
│  │     ├─ 336b00c73a31bc09b4b69dec2dbc245c.php
│  │     ├─ 349def08708437a9bdf9172cf3c6a2ee.php
│  │     ├─ 34a8385f142219cbbbbb5fb81a31319c.php
│  │     ├─ 362d40684cae89500b67a09a45c88f7d.php
│  │     ├─ 36e6628377f29c8187338656cd709069.php
│  │     ├─ 38914141fa74a2c159a62828c51ca096.php
│  │     ├─ 39df4aec3d4971dfb0fa0248fdac4a25.php
│  │     ├─ 3b3e1f23487c39413f6d4a2dfe501db2.php
│  │     ├─ 3d2ceab8059a1f4b3c202377bd7f18db.php
│  │     ├─ 4097b52cd6847b25e6ee98d3c5616d8e.php
│  │     ├─ 4452fdffd0808153169bdd88986871a6.php
│  │     ├─ 477f0d9cf00f69c98c967be78e74b160.php
│  │     ├─ 47d9693ad384a7183aa488fa0fac1c7b.php
│  │     ├─ 484d4a14cb0fad9c707d9c853fa33eb8.php
│  │     ├─ 49cf11fae8a9c78e74ad988a8995cbcc.php
│  │     ├─ 49edfa8bb6ac0d6e23d77a922e0912c0.php
│  │     ├─ 4e0673565e9043e650c0218775219f95.php
│  │     ├─ 5164477a47f0c01ae17ab8c8423d7e62.php
│  │     ├─ 52b7040a39c6342bef0aa165ca276c91.php
│  │     ├─ 5345bae3fd9d7ee83c1310077a65f1a9.php
│  │     ├─ 53b1ec687fb97daf0e1a21282fe1f7b5.php
│  │     ├─ 546305e92cda24283209d0364ae1d78f.php
│  │     ├─ 56856fc958f8cf4dae33ec08185aa848.php
│  │     ├─ 56b52029cd9e588bdde00982f40070bb.php
│  │     ├─ 58067a6bff67911e2a2e7edf6ab595df.php
│  │     ├─ 58709de0f52bdb91325031d349e31ee1.php
│  │     ├─ 59cb75388f8e88374201a2f885d1a8da.php
│  │     ├─ 59d630dd4d167f4baf7409b5e902f5eb.php
│  │     ├─ 5b8205f8079cca971e34381773eb3410.php
│  │     ├─ 5ffbc1a18be636e0aa8482b0a124843d.php
│  │     ├─ 6359f2ccb857dfc0262a6e8e471f997c.php
│  │     ├─ 66ca3c33bc86f297645f7a007f67b05a.php
│  │     ├─ 68484e9e5cbfef852cfb953af8add9e6.php
│  │     ├─ 69f277bc32630eece88c9b3b990928ac.php
│  │     ├─ 6c2a672c1f7ac22f3c98d18b9845d3c7.php
│  │     ├─ 6c2c0672c98f5a43c23ba915d8d5b1cc.php
│  │     ├─ 6c5535f55831353c57c280e5739179e8.php
│  │     ├─ 6c9be2624c3659c948b9463d125d87bb.php
│  │     ├─ 6fa5c6b4dca6eae1b98746cce6e3b3f5.php
│  │     ├─ 7335063e761da4310a1c8c1fd4d8ce11.php
│  │     ├─ 7492edad5f8283b40b9ac3d7b76d33e5.php
│  │     ├─ 74aa9088f33a60c13c6b9f72916d5b69.php
│  │     ├─ 76425a1a7f71a39ea2efba756e01c520.php
│  │     ├─ 76944ea8e763bf93474b18d65c3cb761.php
│  │     ├─ 78184a70d2b0a3cd31b6ff26cf25fac5.php
│  │     ├─ 7828bd9c5aa38994382d93ec4383e8fb.php
│  │     ├─ 788f039dd495fe0793bd9167a8035652.php
│  │     ├─ 78c2ab1c2b045e1c4f01a7b92fccb11e.php
│  │     ├─ 78de445d2815d9af9e417019bfe7377d.php
│  │     ├─ 7b00ec06f5a87faaa3dc82fd348d9697.php
│  │     ├─ 7b25ea85ca9f4f4a3301aa578bef12a1.php
│  │     ├─ 7b38f345bd7f651bc173a26ad215bc83.php
│  │     ├─ 7b45adb88cebbb73d2dc7b43989fd2f9.php
│  │     ├─ 7b79538241a19ff9e5e3718f748a594e.php
│  │     ├─ 7f595cd3960df5bc9881bc12f3ba2e52.php
│  │     ├─ 817beddb57f89232b4f1f6881ca66f31.php
│  │     ├─ 81c5c07922d7d0bb1d685de778f6396b.php
│  │     ├─ 86aff3ac918b601c9aef2b3dfbf48cf6.php
│  │     ├─ 882e28aee375c2bc2e5e9271205e822d.php
│  │     ├─ 8969280542658881f66ae1d3ac95e641.php
│  │     ├─ 8dd969bba176ec14c5bbcea154dd93f9.php
│  │     ├─ 8f128f23bdbe690d367cd40b20ef16d3.php
│  │     ├─ 8fd8827c499928130a66f26287d0103c.php
│  │     ├─ 936783c35884eb199e03e16dc6e690c6.php
│  │     ├─ 941c505cf26fc6e58cb8139a6a5d56a8.php
│  │     ├─ 944f6d860fa3166be4a0b5d541d5321b.php
│  │     ├─ 9512318fbde375eebb03384182c72cdb.php
│  │     ├─ 964e5c24c8f055a3af3db892784bcc7b.php
│  │     ├─ 978993fcc5012b827fcc703f48475a85.php
│  │     ├─ 985efde93e73cd6cd02ddeb58132ff2d.php
│  │     ├─ 9990ac4eb76432447856102af8daa335.php
│  │     ├─ 99c14f316a9aee8b50804f28e38ebbcf.php
│  │     ├─ 9d65dd494c11b9a19e285e5f48cac61f.php
│  │     ├─ 9de40f4bcc0b33f2d9ca92ed3e68463e.php
│  │     ├─ 9ecb56e5bd25b78710b4b8ecace12996.php
│  │     ├─ a1b6bf1146b88d49af57f13d50f9db14.php
│  │     ├─ a2135638fe08d696b747c397a12ed7d7.php
│  │     ├─ a588cc09fc72923a3d111f3ea1343dd0.php
│  │     ├─ a5d51ae4c971f4288eef48ac3c19785c.php
│  │     ├─ a67a8c26343bff14bda9a8bf019a2733.php
│  │     ├─ a6ec89a98d6d5b38a1e255ac717a547e.php
│  │     ├─ a864d07e347570dab2641bcffba4f46b.php
│  │     ├─ aa47ca41d8b78786273149e09bf91f18.php
│  │     ├─ ab5f927cf22681fde76d12ec114ae458.php
│  │     ├─ abc2ed7093c849e38f6ebb60be78ae2a.php
│  │     ├─ af22f0196e8a3ae7e9b5d788f0e48125.php
│  │     ├─ b00420a2fb0eed4a89864cde377faf01.php
│  │     ├─ b248d6a521aedfce28b7d7d9c76949f7.php
│  │     ├─ b82ad7e7f414de1557f4dd210ff967b4.php
│  │     ├─ b83c1d0b7dc0eec7fe7dd9ce968dd2dd.php
│  │     ├─ b862df664d39ea28b7afcd4d424cad44.php
│  │     ├─ ba7bf47440399e72249040d38e3f75a2.php
│  │     ├─ ba947471553d953b463ea805e649caca.php
│  │     ├─ bc6f22dbfb315c43d765c38d2bfa0bbf.php
│  │     ├─ c073d085f9a52c22431029993b5200a6.php
│  │     ├─ c0c4e99537dada52d0e396794cdb6e5c.php
│  │     ├─ c5625a1bfe7852a024a71935398812a4.php
│  │     ├─ c68dbafb1987a0d6096a96b05069fb2d.php
│  │     ├─ c767b149f386b063b19894fc5b2c15f4.php
│  │     ├─ cb6327990b8d8868adb1add6425a5e91.php
│  │     ├─ cc94026e52cc7ca2315b7e85697e487f.php
│  │     ├─ ce7aa635facc24f7f21317776c1c0aa3.php
│  │     ├─ d63acd90dcd88abc31d06f0342b8efc5.php
│  │     ├─ d663c32de909d2e70fabb2f03fa6b6aa.php
│  │     ├─ d8bc6c0899d1607d6765e64f09356090.php
│  │     ├─ da5dbe5038bccdeaa1fe56d864d98a70.php
│  │     ├─ dc337f85a0627539e3b8312a89ed8718.php
│  │     ├─ dc713395164d08fbe619b6c8b106509d.php
│  │     ├─ ddde6e2c108a30f3f65df8bd23f66085.php
│  │     ├─ de6f8628746f7eb9a9498d79856f2f64.php
│  │     ├─ df17a35843babe6ece59073deef20810.php
│  │     ├─ e2194b31183983e4a1f2ac65e3d6a684.php
│  │     ├─ e22539af3c57d9eba96a6b292933b3bc.php
│  │     ├─ e3c8d2b851d6365f92d3e3d95af07135.php
│  │     ├─ e4e5d1d4f841892c66a1dc426819d438.php
│  │     ├─ e632d18b9d776edb9dd163830db0b44d.php
│  │     ├─ e7715a2cafab1db4677935ffacdfe529.php
│  │     ├─ e9788eefef897c1ae3c73c2b315a763e.php
│  │     ├─ ee9207b8101dec5a4b7bdddeed2104a5.php
│  │     ├─ ee9439e5b0ec173a2285e448f0ff7f7f.php
│  │     ├─ f30549925925ab2182928f2fc0cff259.php
│  │     ├─ f31cb55e9ffd8403caa04fad2c554ad7.php
│  │     ├─ f3c29745e89963a24c811fd40416dcfd.php
│  │     ├─ f4ce37e540e9db9865750c5250f364fe.php
│  │     ├─ f6cf5dec171f15dfa674030cea7e7853.php
│  │     ├─ f97cfaa04df630ee45fe1a694423aa3b.php
│  │     ├─ f9c97cc8560c72f15f648dc98b20f7af.php
│  │     ├─ fb7d3a92a2d06bba3287ac66a2f878eb.php
│  │     ├─ fd3423b86210821065d75165ba339bec.php
│  │     ├─ fdcd6fc4f3f36aa76fcfbcb4a4ca5f1b.php
│  │     ├─ ff5550095a085af2a61a579867793d46.php
│  │     └─ ffa2ffb8794e3ca28ec13c5fb343c408.php
│  └─ logs
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  ├─ ExampleTest.php
│  │  ├─ PendaftaranTest.php
│  │  └─ ProfileTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```