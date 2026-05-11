# Peran Pengguna & User Story: AltiGuide (Revised)

## 1. Peran Pengguna (User Roles)
* **Pendaki (Hiker):** Pengguna aplikasi (Mobile/Web) yang melakukan pendaftaran, eksplorasi rute, pembayaran SIMAKSI, dan navigasi lapangan.
* **Superadmin:** Pengelola pusat yang mengontrol data master (Gunung, Rute, User, & GPX) melalui CMS Web.
* **Basecamp Staff:** Petugas di gerbang jalur yang melakukan verifikasi tiket pendaki (*Check-in*) dan mengelola status operasional jalur lokal.

---

## 2. User Story & Acceptance Criteria

### [FITUR 1: AUTENTIKASI & MANAJEMEN AKUN]

#### US-01: Registrasi Akun Baru (Hiker)
**Sebagai** Pendaki, **saya ingin** membuat akun baru dengan data diri lengkap, **agar** saya dapat menggunakan layanan AltiGuide dan data saya tercatat resmi untuk keselamatan.
* **AC-1 (Normal):** Form mencakup Email, Password, NIK (16 digit), No HP, Alamat, dan Kontak Darurat.
* **AC-2 (Error - Validasi):** Sistem menolak pendaftaran jika format email salah atau NIK tidak berjumlah tepat 16 digit.
* **AC-3 (Error - Duplikasi):** Menampilkan pesan "Data sudah terdaftar" jika Email atau NIK sudah ada di database.

#### US-02: Login ke Sistem (Hiker)
**Sebagai** Pendaki, **saya ingin** masuk ke akun saya, **agar** saya dapat mengakses fitur personal seperti riwayat transaksi.
* **AC-1 (Normal):** Login berhasil menggunakan email dan password yang sesuai.
* **AC-2 (Security):** Sistem menampilkan pesan "Kredensial salah" tanpa merinci letak kesalahan demi keamanan.
* **AC-3 (Persistence):** Mobile menyimpan *token* di DataStore lokal; Web menggunakan *session cookie*.

#### US-03: Lupa Password via OTP (Hiker)
**Sebagai** Pendaki, **saya ingin** mereset password melalui OTP, **agar** saya dapat memulihkan akses akun jika lupa kredensial.
* **AC-1 (Normal):** Verifikasi menggunakan kode OTP 6 digit yang dikirim ke email.
* **AC-2 (Error - Expired):** Kode OTP hanya berlaku selama 15 menit. Jika lewat, user harus meminta kode baru.

#### US-04: Logout dari Sistem (Hiker)
**Sebagai** Pendaki, **saya ingin** keluar dari aplikasi, **agar** akun saya tetap aman.
* **AC-1 (Normal):** Menghapus token di server dan lokal; mengarahkan user kembali ke halaman Login.

#### US-05: Lihat & Edit Profil (Hiker)
**Sebagai** Pendaki, **saya ingin** memperbarui informasi profil, **agar** kontak darurat saya selalu akurat.
* **AC-1 (Restriction):** Field Email dan NIK bersifat *read-only* (tidak dapat diubah) untuk validasi hukum SIMAKSI.

#### US-06: Ubah Kata Sandi (Hiker)
**Sebagai** Pendaki, **saya ingin** mengubah password dari dalam aplikasi, **agar** keamanan akun terjaga berkala.
* **AC-1 (Normal):** Wajib memasukkan password lama yang valid sebagai syarat pembuatan password baru.

---

### [FITUR 2: EKSPLORASI GUNUNG & RUTE]

#### US-07: Lihat Daftar Gunung (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat daftar gunung, **agar** saya dapat menentukan tujuan pendakian.
* **AC-1 (Normal):** Menampilkan nama, mdpl, provinsi, dan status (Buka/Tutup) secara publik tanpa login.

#### US-08: Detail Gunung & Pilihan Rute (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat rincian rute, **agar** saya dapat memilih jalur yang sesuai kemampuan.
* **AC-1 (Normal):** Menampilkan deskripsi, tingkat kesulitan, jarak (km), dan biaya SIMAKSI.

#### US-09: Detail Rute & Waypoint (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat urutan pos, **agar** saya dapat merencanakan titik perbekalan air.
* **AC-1 (Normal):** Waypoint ditampilkan berurutan (Basecamp ke Puncak) dengan indikator sumber air (✓/✗).

#### US-10: Informasi Cuaca Real-Time (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat cuaca di puncak dan basecamp, **agar** dapat mendaki dengan aman.
* **AC-1 (Normal):** Mengambil data suhu dan angin dari API Open-Meteo berdasarkan koordinat gunung.
* **AC-2 (Error - Timeout):** Jika API gagal, sistem menampilkan teks "Informasi cuaca sedang tidak tersedia".

---

### [FITUR 3: PEMESANAN SIMAKSI - WEB ONLY]

#### US-11: Membuat Booking SIMAKSI (Hiker)
**Sebagai** Pendaki, **saya ingin** memesan izin mendaki daring, **agar** kuota pendakian saya terjamin.
* **AC-1 (Validation):** Sistem memvalidasi sisa kuota harian. Jika penuh, sistem menolak pemesanan pada tanggal tersebut.

#### US-12: Validasi NIK Anggota (Hiker)
**Sebagai** Pendaki, **saya ingin** memvalidasi NIK anggota kelompok, **agar** memastikan semua anggota sudah punya akun.
* **AC-1 (Error - Conflict):** Sistem menolak anggota yang sudah memiliki jadwal pendakian aktif (bentrok) di tanggal yang sama.

#### US-13: Pembayaran QRIS (Hiker)
**Sebagai** Pendaki, **saya ingin** membayar via QRIS, **agar** proses instan tanpa verifikasi manual.
* **AC-1 (Condition):** Pembayaran kadaluarsa dalam 1 jam. Status otomatis berubah menjadi "Lunas" via Midtrans Webhook.

#### US-14: Menerima E-Ticket (Hiker)
**Sebagai** Pendaki, **saya ingin** mendapatkan E-Ticket, **agar** memiliki bukti resmi untuk petugas.
* **AC-1 (Normal):** QR Code tiket diterbitkan secara otomatis hanya jika status pembayaran adalah "Lunas".

---

### [FITUR 4: RIWAYAT & E-TICKET]

#### US-15: Lihat Riwayat Transaksi (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat semua riwayat pemesanan, **agar** dapat memantau status pembayaran.
* **AC-1 (Normal):** Data sinkron antara Web dan Mobile melalui API pusat.

#### US-16: Detail Transaksi (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat rincian pemesanan, **agar** dapat memastikan data perjalanan benar.
* **AC-1 (Normal):** Menampilkan rincian biaya, daftar anggota, dan tombol unduh tiket jika sudah lunas.

#### US-17: Unduh PDF E-Ticket (Hiker - Mobile Only)
**Sebagai** Pendaki, **saya ingin** menyimpan tiket di HP, **agar** bisa ditunjukkan secara luring.
* **AC-1 (Normal):** File PDF disimpan ke memori lokal dan dibuka via PDF Viewer sistem.

---

### [FITUR 5: NAVIGASI OFFLINE - MOBILE ONLY]

#### US-18: Lihat Sesi Pendakian Aktif (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat sesi aktif, **agar** dapat memulai panduan navigasi lapangan.
* **AC-1 (Normal):** Menampilkan status sesi (Siap / Dalam Pendakian / Selesai).

#### US-19: Caching Navigasi Offline (Hiker)
**Sebagai** Pendaki, **saya ingin** menyimpan data rute ke database lokal, **agar** peta bisa diakses tanpa sinyal.
* **AC-1 (Normal):** Data waypoint disimpan otomatis ke Room DB lokal saat layar detail rute dibuka dalam kondisi online.
* **AC-2 (Error - Storage):** Jika memori internal <100MB, sistem memberikan peringatan penyimpanan penuh.

#### US-20: Navigasi Offline di Gunung (Hiker)
**Sebagai** Pendaki, **saya ingin** menggunakan peta dari database lokal, **agar** tidak tersesat di area tanpa sinyal.
* **AC-1 (Normal):** Menampilkan daftar checkpoint luring dengan banner indikator "Mode Offline".

---

### [FITUR 6: ADMIN & MANAJEMEN SISTEM - WEB ONLY]

#### US-21: Login Panel Admin (Admin/Staff)
**Sebagai** Admin, **saya ingin** masuk ke panel pengelola, **agar** manajemen data aman dari akses publik.
* **AC-1 (Security):** Menggunakan URL khusus `/admin/login` dengan guard autentikasi terpisah.

#### US-22: Kelola Data Gunung (Superadmin)
**Sebagai** Superadmin, **saya ingin** melakukan CRUD data gunung, **agar** informasi sistem tetap mutakhir.
* **AC-1 (Safety):** Gunung yang memiliki rute aktif tidak diizinkan untuk dihapus (proteksi data).

#### US-23: Kelola Rute & Basecamp (Superadmin)
**Sebagai** Superadmin, **saya ingin** mengelola info rute dan logistik, **agar** tarif dan kuota selalu akurat.
* **AC-1 (Normal):** Mengatur tingkat kesulitan, estimasi waktu, dan detail ojek/fasilitas basecamp.

#### US-24: Kelola Waypoint Rute (Superadmin)
**Sebagai** Superadmin, **saya ingin** mengatur titik checkpoint, **agar** navigasi mobile sesuai kondisi lapangan.
* **AC-1 (Normal):** Mengatur urutan pos menggunakan `order_index` untuk akurasi navigasi offline.

#### US-25: Scan & Verifikasi E-Ticket (Staff)
**Sebagai** Basecamp Staff, **saya ingin** memindai tiket pendaki, **agar** dapat memvalidasi izin masuk secara cepat.
* **AC-1 (Normal):** Verifikasi berhasil jika status tiket "Lunas". Staff mengubah status sesi menjadi "On Track".
* **AC-2 (Error - Invalid):** Menampilkan peringatan jika tiket sudah kadaluwarsa atau sudah pernah digunakan.
