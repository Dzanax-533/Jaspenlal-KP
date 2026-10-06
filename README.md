# JASPENLAL - Sistem Informasi Pengelolaan Jasa Pendampingan Konsultan Halal

**Platform Terintegrasi untuk Manajemen Proses Sertifikasi Halal dari Registrasi hingga Issuance**

---

## 📋 Overview

JASPENLAL adalah sistem informasi komprehensif yang mengotomatisasi seluruh alur proses pendampingan sertifikasi halal, mulai dari pendaftaran klien, penugasan konsultan, validasi dokumen, audit lapangan, hingga penerbitan sertifikat. Platform ini dirancang untuk **Lembaga Sertifikasi Halal** dan **Konsultan Halal** guna meningkatkan efisiensi operasional dan transparansi dalam pengelolaan jasa konsultasi sertifikasi halal.

**Fitur Utama:**
- Multi-level progress tracking (10 tahap)
- Automated workflow orchestration
- Livewire-powered reactive components
- PDF invoice generation
- Role-based document validation
- WhatsApp notification integration

---

## 🎯 Problem Statement

**Tantangan Bisnis:**
1. Proses pendampingan sertifikasi halal masih tersebar di berbagai aplikasi/spreadsheet
2. Tidak ada real-time tracking status untuk klien dan lembaga sertifikasi
3. Penugasan konsultan bersifat manual tanpa sistem terstruktur
4. Validasi dokumen dan bahan memerlukan koordinasi kompleks antar tim
5. Invoicing dan tracking pembayaran termin tidak terintegrasi
6. Sulit memantau tahap audit lapangan dan penerbitan sertifikat

---

## ✨ Features

### 🔐 **1. Multi-Role Authentication & Authorization**
- **Admin** → Manajemen operasional, plotting konsultan, penerbitan sertifikat
- **Klien** → Pendaftaran, upload dokumen, pembayaran, tracking status
- **Konsultan** → Validasi dokumen, evaluasi bahan, audit lapangan, upload LHA
- **Keuangan** → Verifikasi pembayaran DP & Pelunasan, tracking termin
- Implementasi: **Laravel Breeze** + Custom Middleware Role-Based

### 📊 **2. 10-Level Progress Tracking System**

Platform menggunakan sistem 10-level progress yang terstruktur:

| Level | Deskripsi | Status | Role Utama |
|-------|-----------|--------|-----------|
| 0 | Profil Perusahaan (Wajib) | Intake | Klien |
| 1 | Pendaftaran Baru | Menunggu DP | Klien |
| 2 | Upload Bukti Pembayaran DP | Verifikasi DP | Klien + Keuangan |
| 3 | DP Diterima / Ditolak | Antrean Plotting | Keuangan |
| 4 | Plotting Konsultan | Assign Konsultan | Admin |
| 5 | Upload Dokumen Persyaratan | Dokumen Terbuka | Klien |
| 6 | Evaluasi & Daftar Bahan | Evaluasi Bahan | Konsultan |
| 7 | Audit Lapangan | Audit Berlangsung | Konsultan |
| 8 | Upload LHA & Sidang Fatwa | Sidang Fatwa | Konsultan + Admin |
| 9 | Menunggu Pelunasan (40%) | Menunggu Bayar 2 | Klien + Keuangan |
| 10 | Sertifikat Halal Terbit | Sertifikat Diterbitkan | Admin |

### 💼 **3. Document & Material Management**

**Dokumen Klien (Level 5):**
- Surat Permohonan
- Formulir Pendaftaran
- NIB (Nomor Identitas Bisnis)
- Penyelia Halal
- Fasilitas Pabrik
- Daftar Produk
- Daftar Bahan
- Diagram Alir
- Manual SJH (Sistem Jaminan Halal)

**Material Management (Level 6):**
- Input daftar bahan baku yang digunakan
- Validasi dan approval oleh konsultan
- Tracking komposisi dan supplier

### 💳 **4. Integrated Payment System**

- **Termin 1 (DP)**: 60% dari total biaya
- **Termin 2 (Pelunasan)**: 40% setelah audit selesai
- Invoice generation otomatis (PDF)
- Payment status tracking
- Bukti pembayaran upload & verifikasi
- Download invoice untuk klien

### 📱 **5. WhatsApp Notification Integration**

- Notifikasi real-time status perubahan ke klien, konsultan, admin
- Reminder pembayaran, deadline dokumen
- Status audit dan sertifikat
- Service: `WhatsappService.php`

### 🎨 **6. Reactive Components (Livewire 3)**

- Real-time progress indicator
- Dynamic form validation
- Live document list updates
- Instant status notifications
- Component: `PendaftaranProgress.php`

### 📄 **7. PDF Report Generation**

- Invoice PDF (Termin 1 & 2)
- Sertifikat Halal PDF
- Laporan Audit (LHA)
- Library: **barryvdh/laravel-dompdf**

### 🔍 **8. Business Logic Services**

**PendaftaranService** → Core workflow logic
- Validasi profil lengkap
- Progress level management
- Perhitungan biaya dinamis (menu tambahan, outlet tambahan)
- Nomor pendaftaran auto-generation

**KeuanganService** → Payment & invoice management
**EvaluasiService** → Document & material evaluation logic

---

## 🛠️ Tech Stack

### **Backend**
- **Framework**: Laravel 12.0 + PHP 8.2
- **ORM**: Eloquent (Laravel)
- **Database**: SQLite (development) / MySQL (production)
- **Authentication**: Laravel Breeze
- **Reactive Components**: Livewire 3.7
- **PDF Generator**: barryvdh/laravel-dompdf

### **Frontend**
- **Templating**: Blade (Laravel)
- **CSS Framework**: Tailwind CSS 3.1 + Forms Plugin
- **JavaScript**: Alpine.js 3.4
- **Bundler**: Vite 7.0 + Laravel Vite Plugin
- **HTTP Client**: Axios 1.11

### **Key Dependencies**
- `livewire/livewire` → Reactive components
- `barryvdh/laravel-dompdf` → PDF generation
- `laravel/breeze` → Authentication scaffolding

### **Development Tools**
- `laravel/pail` → Log viewer
- `laravel/pint` → PHP styling
- `laravel/sail` → Docker environment
- `phpunit/phpunit` → Testing

---

## 🏗️ System Architecture

### **Directory Structure**

```
Jaspenlal-KP/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminController.php      # Operasional & sertifikat
│   │   │   │   └── UserController.php       # User & paket management
│   │   │   ├── Auth/                        # Breeze authentication
│   │   │   ├── Klien/
│   │   │   │   ├── ProfilController.php     # Profil perusahaan
│   │   │   │   ├── PendaftaranController.php # Intake & registration
│   │   │   │   ├── TransaksiController.php  # Invoice & payment
│   │   │   │   ├── DokumenController.php    # Document upload
│   │   │   │   └── BahanController.php      # Material input
│   │   │   ├── Keuangan/
│   │   │   │   └── KeuanganController.php   # Payment verification
│   │   │   ├── Konsultan/
│   │   │   │   ├── KonsultanController.php  # Audit & assignment
│   │   │   │   └── EvaluasiController.php   # Document/material evaluation
│   │   │   ├── DashboardController.php      # Role-based gateway
│   │   │   └── ProfileController.php        # Breeze profile
│   │   ├── Middleware/
│   │   │   ├── EnsureProfilLengkap.php      # Check Level 0 completion
│   │   │   └── RoleMiddleware.php           # Role authorization
│   │   └── Requests/
│   │       ├── Auth/LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Livewire/
│   │   └── PendaftaranProgress.php          # ⭐ Reactive progress component
│   ├── Models/                               # 9 Eloquent Models
│   │   ├── User.php
│   │   ├── Pendaftaran.php    # Core registration model
│   │   ├── Paket.php          # Service packages
│   │   ├── Pembayaran.php     # Payment records
│   │   ├── KlienDetail.php    # Company profile
│   │   ├── Bahan.php          # Materials
│   │   ├── Dokumen.php        # Documents
│   │   └── Transaksi.php      # Transactions
│   ├── Services/
│   │   ├── PendaftaranService.php     # Progress & billing logic
│   │   ├── KeuanganService.php        # Payment management
│   │   ├── EvaluasiService.php        # Evaluation logic
│   │   └── WhatsappService.php        # WhatsApp notifications
│   ├── View/Components/
│   │   ├── AppLayout.php
│   │   └── GuestLayout.php
│   └── Providers/
│       └── AppServiceProvider.php
├── routes/
│   ├── web.php                 # Main routing (4 role groups + 10-level flow)
│   ├── auth.php                # Breeze auth routes
│   └── console.php             # Artisan commands
├── resources/
│   ├── views/                  # Blade templates
│   │   ├── admin/              # Admin dashboards & operasional
│   │   ├── klien/              # Klien intake & tracking
│   │   ├── konsultan/          # Consultant evaluation & audit
│   │   ├── keuangan/           # Finance verification
│   │   ├── layouts/
│   │   └── components/
│   ├── css/
│   │   └── app.css             # Tailwind imports
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── database/
│   ├── migrations/             # 16 migrations (users, paket, pendaftaran, dll)
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── PaketSeeder.php     # Initial package pricing
│       └── UserSeeder.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── services.php            # WhatsApp & external APIs
├── storage/
│   ├── uploads/                # User documents
│   └── invoices/               # Generated PDFs
├── public/
│   ├── index.php
│   ├── favicon.ico
│   └── img/
│       └── logo-khi.png
├── tests/                      # PHPUnit test suite
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
├── .env.example
└── README.md
```

### **Data Flow Architecture**

```
┌──────────────────┐
│  KLIEN (Web)     │  1. Input Profil Perusahaan (Level 0)
└────────┬─────────┘
         │
         ↓
┌──────────────────────────────────┐
│ ProfilController.store()         │  2. Validate & Store KlienDetail
│ + EnsureProfilLengkap Middleware │
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ PendaftaranController.store()    │  3. Buat Pendaftaran (Level 1)
│ + PendaftaranService             │     invoice DP 60% generated
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ TransaksiController              │  4. Upload Bukti Bayar (Level 2)
│ → storeBayar()                   │     Keuangan verifikasi
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ KeuanganController               │  5. Approve DP (Level 3 → 4)
│ → verifikasi()                   │     Send to admin plotting queue
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ AdminController                  │  6. Assign Konsultan (Level 4 → 5)
│ → assignKonsultan()              │     Gembok dokumen dibuka
│ + PendaftaranService             │
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ DokumenController.upload()       │  7. Upload Dokumen Persyaratan (Level 5)
│ + BahanController.store()        │     Input Bahan Baku
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ EvaluasiController               │  8. Konsultan Validasi (Level 6)
│ → validasiDokumen() &            │     Evaluasi Bahan
│ → validasiBahan()                │     Jadwalkan Audit
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ KonsultanController              │  9. Audit Lapangan (Level 7 → 8)
│ → uploadLHA()                    │     Input Tgl Audit & Upload LHA
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ AdminController                  │  10. Sidang Fatwa & Ketetapan (Level 8 → 9)
│ → uploadKetetapan()              │      Upload Ketetapan Halal
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ KeuanganController               │  11. Verifikasi Pelunasan (Level 9)
│ → verifikasi() for Termin 2      │      Generate invoice 40%
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│ AdminController                  │  12. Penerbitan Sertifikat (Level 10)
│ → uploadSertifikatFinal()        │      Upload Sertifikat Halal
└────────┬─────────────────────────┘
         │
         ↓
┌──────────────────────────────────┐
│  KLIEN Dashboard                 │  13. Download Sertifikat
│  (PendaftaranController)         │      Status = Completed
└──────────────────────────────────┘
```

---

## 🚀 Installation

### **Prerequisites**
- PHP 8.2+
- Composer
- Node.js 16+ & npm
- MySQL / SQLite
- Git

### **Quick Setup (1 Command)**

```bash
# Clone repository
git clone https://github.com/Dzanax-533/Jaspenlal-KP.git
cd Jaspenlal-KP

# Run setup (install dependencies + migrate + seed + build frontend)
composer run setup
```

**Yang dilakukan `setup` script:**
1. `composer install` → Install PHP dependencies
2. Copy `.env.example` → `.env` (if not exists)
3. `php artisan key:generate` → Generate APP_KEY
4. `php artisan migrate --force` → Run database migrations
5. `npm install` → Install frontend deps
6. `npm run build` → Build Tailwind + Vite assets

### **Manual Setup (Step-by-Step)**

```bash
# 1. Install PHP dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Database setup
php artisan migrate
php artisan db:seed  # Seeds demo users & packages

# 4. Install & build frontend
npm install
npm run build

# 5. Serve application
php artisan serve
```

### **Seeding Demo Data**

```bash
# Seed test users & packages
php artisan db:seed

# Creates:
# - Admin (email: admin@jaspenlal.test, password: password)
# - Konsultan (email: konsultan@jaspenlal.test, password: password)
# - Keuangan (email: keuangan@jaspenlal.test, password: password)
# - 3 Demo Klien users
# - 3 Service packages (Silver, Gold, Platinum)
```

### **Environment Variables** (.env)

```dotenv
# Application
APP_NAME="JASPENLAL"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (SQLite by default)
DB_CONNECTION=sqlite
# OR MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=jaspenlal_db
# DB_USERNAME=root
# DB_PASSWORD=password

# Session & Cache
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# WhatsApp Gateway (Optional)
WHATSAPP_API_KEY=your_api_key
WHATSAPP_SENDER_NUMBER=+62xxxx

# File Storage
FILESYSTEM_DISK=local
```

### **Development Mode**

```bash
# Terminal 1: Full stack (PHP + Queue + Logs + Vite)
composer run dev

# Terminal 2 (if separate): Frontend watcher only
npm run dev

# Access: http://localhost:8000
# Demo Login: admin@jaspenlal.test / password
```

---

## 🧪 Testing

### **Run Tests**

```bash
# All tests
composer test

# Specific test file
php artisan test tests/Unit/PendaftaranServiceTest.php

# With coverage
php artisan test --coverage
```

### **PHPUnit Configuration**
- Config: `phpunit.xml`
- Test directory: `tests/`
- Database: SQLite in-memory

---

## 📊 Database Schema (Key Tables)

```sql
-- Users (Authentication & Roles)
users
├── id, name, email, password
├── role (admin|klien|konsultan|keuangan)
└── timestamps

-- KlienDetail (Company Profile - Level 0)
klien_details
├── user_id, nama_perusahaan, npwp
├── alamat_perusahaan, skala_usaha
├── penyelia_halal, kontak_person
└── timestamps

-- Pendaftaran (Main Registration - Core Model)
pendaftarans
├── id, user_id, konsultan_id, paket_id
├── no_pendaftaran (auto-generated)
├── total_menu, total_outlet, luar_jabodetabek
├── biaya_dasar, biaya_menu_tambahan, biaya_outlet_tambahan, total_biaya
├── progress_level (0-10), status
├── tgl_audit, tgl_sidang
├── file_lha, file_ketetapan_halal, file_sertifikat
└── timestamps

-- Paket (Service Packages)
pakets
├── id, nama_paket (Silver|Gold|Platinum)
├── harga, deskripsi
└── timestamps

-- Pembayaran (Payment Records - Termin 1 & 2)
pembayarans
├── id, pendaftaran_id
├── termin (1|2), nominal
├── status (menunggu|verifikasi|diterima|ditolak)
├── bukti_pembayaran, catatan_keuangan
└── timestamps

-- Dokumen (User Documents - Level 5)
dokumens
├── id, pendaftaran_id
├── tipe_dokumen, file_path
├── status (uploaded|validated|rejected)
└── timestamps

-- Bahan (Materials - Level 6)
bahans
├── id, pendaftaran_id
├── nama_bahan, komposisi, supplier
├── status (submitted|validated)
└── timestamps

-- Transaksi (Transaction Audit Trail)
transaksis
├── id, pendaftaran_id
├── tipe_transaksi, nominal, status
└── timestamps
```

---

## 📚 API/Routes Overview

### **Route Groups by Role & Level**

#### **1. Klien Routes** (`/klien/*`)
```
Level 0: GET/POST /klien/profil
Level 1: GET/POST /klien/pendaftaran & /klien/pendaftaran/baru
Level 2: GET /klien/transaksi/invoice/{id}
         POST /klien/transaksi/bayar/{id}
         GET /klien/transaksi/invoice/{id}/download
Level 3-6: GET/POST /klien/dokumen (upload, delete, view)
Level 4: GET/POST /klien/bahan
Level 10: GET /klien/sertifikat (download)
```

#### **2. Keuangan Routes** (`/keuangan/*`)
```
GET /keuangan/dashboard
GET /keuangan/termin-1 & /keuangan/termin-2
POST /keuangan/verifikasi/{id}
POST /keuangan/tolak/{id}
```

#### **3. Konsultan Routes** (`/konsultan/*`)
```
GET /konsultan/dashboard
GET /konsultan/evaluasi/validasi-dokumen
GET /konsultan/evaluasi/evaluasi-bahan
POST /konsultan/evaluasi/validasi-dokumen/{id}
POST /konsultan/evaluasi/validasi-bahan/{id}
GET /konsultan/audit
POST /konsultan/audit/upload/{id}
```

#### **4. Admin Routes** (`/admin/*`)
```
GET /admin/dashboard
GET /admin/operasional/plotting
POST /admin/operasional/assign
GET /admin/operasional/sidang-fatwa
POST /admin/operasional/sidang-fatwa/{id}
GET /admin/operasional/penerbitan
POST /admin/operasional/penerbitan/{id}
GET/POST /admin/users (CRUD)
GET/PUT /admin/paket
```

---

## 🎨 Key Components & Features

### **1. Livewire Component: PendaftaranProgress**
Real-time progress indicator showing all 10 levels with dynamic status updates.

### **2. PDF Invoice Generation**
Automatic invoice creation for Termin 1 (DP 60%) and Termin 2 (Pelunasan 40%).

### **3. Dynamic Pricing Calculator**
Implemented in `PendaftaranService::hitungTotalBiaya()`:
- Base price (depends on package)
- Additional menu surcharge (per 30 items after 50)
- Additional outlet surcharge (Rp 1.5M per outlet)
- Luar Jabodetabek premium (configurable)

### **4. Auto-Generated Registration Number**
Format: `REG-YYYYMMDD-XXX` (e.g., REG-20260124-001)

### **5. Document Lifecycle**
- Uploaded (Level 5)
- Validated by Consultant (Level 6)
- Referenced in LHA (Level 8)
- Finalized (Level 10)

---

## 🔒 Security Features

- **Authentication**: Laravel Breeze (session-based)
- **Authorization**: Role-based middleware + custom guards
- **CSRF Protection**: Token verification on all POST/PUT/DELETE
- **SQL Injection Prevention**: Eloquent ORM parameterized queries
- **File Upload Validation**: MIME type + size checking
- **Environment Variables**: Sensitive keys in `.env` (not in git)

---

## 📱 Integration Points

### **WhatsApp Notifications**
Service: `WhatsappService.php`

Notifications sent for:
- DP payment reminder
- Konsultan assignment
- Document deadline
- Audit schedule
- Sertifikat ready

### **Email (Optional)**
Laravel Mail configured for:
- Invoice delivery
- Payment confirmations
- Status updates

---

## 🤝 Contributing

1. Fork repository
2. Create feature branch: `git checkout -b feature/nama-fitur`
3. Commit changes: `git commit -m "Add fitur baru"`
4. Push branch: `git push origin feature/nama-fitur`
5. Open Pull Request

---

## 📝 License

This project is licensed under the MIT License — see LICENSE file for details.

---

## 👨‍💼 Author

**Dzanax-533**  
GitHub: [@Dzanax-533](https://github.com/Dzanax-533)

### **Created For**
Sistem Informasi Pengelolaan Jasa Pendampingan Konsultan Halal - Kerja Praktik/Tugas Akhir

---

## 📞 Support & Documentation

- **Issues**: Report bugs via [GitHub Issues](https://github.com/Dzanax-533/Jaspenlal-KP/issues)
- **Discussions**: Q&A via [GitHub Discussions](https://github.com/Dzanax-533/Jaspenlal-KP/discussions)
- **Laravel Docs**: https://laravel.com/docs
- **Livewire Docs**: https://livewire.laravel.com

---

## 🗂️ Workflow Documentation

### **10-Level Progress Flow**

**Level 0 → 1**: Profil Lengkap → Pendaftaran Dibuat
- Middleware: `EnsureProfilLengkap`
- Service: `PendaftaranService::isProfilLengkap()`

**Level 1 → 2**: Upload Bukti DP
- Controller: `TransaksiController::storeBayar()`
- Model: `Pembayaran` (termin = 1)

**Level 2 → 3**: Keuangan Verifikasi / Tolak
- Controller: `KeuanganController::verifikasi() | tolak()`
- Service: `KeuanganService`

**Level 3 → 4**: Admin Plot Konsultan
- Controller: `AdminController::assignKonsultan()`
- Trigger: Gembok dokumen level 5 dibuka

**Level 4 → 5**: Klien Upload Dokumen & Bahan
- Controllers: `DokumenController`, `BahanController`
- Models: `Dokumen`, `Bahan`

**Level 5 → 6**: Konsultan Validasi
- Controller: `EvaluasiController::validasiDokumen() | validasiBahan()`

**Level 6 → 7**: Jadwal Audit & Input Tanggal
- Controller: `KonsultanController::formAudit()`

**Level 7 → 8**: Upload LHA
- Controller: `KonsultanController::uploadLHA()`

**Level 8 → 9**: Admin Upload Ketetapan & Sidang Fatwa
- Controller: `AdminController::uploadKetetapan()`
- Trigger: Generate invoice Termin 2 (40%)

**Level 9 → 10**: Keuangan Verifikasi Pelunasan & Admin Upload Sertifikat
- Controllers: `KeuanganController::verifikasi() | tolak()`
- Controller: `AdminController::uploadSertifikatFinal()`
- Final Status: "Sertifikat Halal Terbit"

---

**Last Updated**: January 2026  
**Laravel Version**: 12.0  
**PHP Version**: 8.2+  
**Status**: Production Ready ✅
