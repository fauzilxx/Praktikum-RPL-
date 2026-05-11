# User Stories & Acceptance Criteria: AltiGuide

## 1. Peran Pengguna (User Roles)
* **Hiker (User App):** Pengguna aplikasi mobile untuk kebutuhan pendakian.
* **Superadmin (Admin CMS):** Pengelola data master (Gunung, Rute, User) dan infrastruktur data navigasi.
* **Basecamp Staff (Admin CMS):** Petugas lapangan untuk verifikasi tiket dan pemantauan jalur lokal.

---

## 2. User Story & Acceptance Criteria (Hiker - Mobile App)

### US-01: Autentikasi Pengguna
**Sebagai** Hiker,  
**Saya ingin** melakukan registrasi dan login dengan sistem OTP email,  
**Agar** akun saya terverifikasi dengan aman.

* **AC-1 (Normal):** Sistem mengirimkan 6 digit kode OTP ke email yang didaftarkan secara real-time.
* **AC-2 (Error - Invalid OTP):** Jika kode OTP yang dimasukkan salah, sistem menampilkan pesan "Kode OTP tidak valid" dan memberikan kesempatan hingga 3 kali percobaan sebelum memblokir input selama 5 menit.
* **AC-3 (Error - Expired OTP):** Jika OTP dimasukkan setelah melewati batas waktu 5 menit, sistem menampilkan pesan "Kode OTP kadaluwarsa" dan menyediakan tombol "Kirim Ulang".
* **AC-4 (Validation):** Sistem menolak pendaftaran jika format email tidak sesuai standar (misal: tanpa @) atau email sudah terdaftar di database.

### US-02: Pemesanan SIMAKSI & Pembayaran
**Sebagai** Hiker,  
**Saya ingin** melakukan pemesanan SIMAKSI dan membayar secara daring,  
**Agar** saya mendapatkan izin pendakian tanpa antre di lokasi.

* **AC-1 (Validation - Kelengkapan):** Sistem mewajibkan pengisian NIK (16 digit), Nama, dan No. HP Kontak Darurat. Tombol "Bayar" tidak akan aktif jika salah satu kolom kosong.
* **AC-2 (Validation - Format File):** Sistem hanya menerima unggahan dokumen identitas dalam format JPG, PNG, atau PDF dengan ukuran maksimal 2MB. File di luar ketentuan tersebut akan ditolak dengan pesan kesalahan yang sesuai.
* **AC-3 (Error - Payment Timeout):** Jika pembayaran tidak diselesaikan dalam waktu 15 menit (untuk metode QRIS), sistem secara otomatis membatalkan pesanan dan mengembalikan kuota pendakian ke status tersedia.

### US-03: Informasi Katalog & Cuaca
**Sebagai** Hiker,  
**Saya ingin** melihat katalog gunung dan prediksi cuaca rute terkait,  
**Agar** saya dapat mengantisipasi kondisi di lapangan.

* **AC-1 (Normal):** Sistem menampilkan prakiraan cuaca (suhu, kelembapan, kondisi langit) untuk 3 hari ke depan berdasarkan koordinat rute.
* **AC-2 (Alternative - API Failure):** Jika data cuaca gagal ditarik dari API (timeout/error), sistem menampilkan pesan "Informasi cuaca sedang tidak tersedia" dan menampilkan data terakhir yang tersimpan di cache (jika ada).

### US-04: Navigasi Luring (Offline Map)
**Sebagai** Hiker,  
**Saya ingin** mengunduh paket peta luring dan melacak posisi saya,  
**Agar** saya tidak tersesat di area tanpa sinyal seluler.

* **AC-1 (Normal):** Sistem menampilkan progres unduhan dalam persentase (%) dan notifikasi "Unduhan Selesai".
* **AC-2 (Error - Storage):** Jika ruang penyimpanan perangkat tidak mencukupi (<100MB), sistem membatalkan proses unduhan dan memberikan peringatan "Penyimpanan tidak mencukupi".
* **AC-3 (Error - GPS):** Jika fitur lokasi (GPS) pada perangkat non-aktif, sistem menampilkan dialog permintaan aktivasi lokasi sebelum memulai navigasi.

---

## 3. User Story & Acceptance Criteria (Admin - CMS)

### US-05: Dashboard Statistik & Laporan (Admin)
**Sebagai** Admin,  
**Saya ingin** melihat visualisasi statistik pendaftaran di dashboard,  
**Agar** saya dapat memantau tren pendakian secara informatif.

* **AC-1 (Filtering):** Sistem menyediakan filter rentang waktu (Harian, Mingguan, Bulanan, dan Custom Range) yang memperbarui data secara dinamis.
* **AC-2 (Visualisasi):** Menampilkan **Bar Chart** untuk jumlah pendaftar per jalur pendakian dan **Pie Chart** untuk persentase status transaksi (Paid vs Unpaid).
* **AC-3 (Data Integrity):** Setiap grafik harus dilengkapi dengan legenda yang jelas dan label nilai pada sumbu X dan Y untuk menghindari ambiguitas data.

### US-06: Manajemen Data Master & GPX (Superadmin)
**Sebagai** Superadmin,  
**Saya ingin** mengelola data rute dan mengunggah file navigasi GPX,  
**Agar** peta navigasi di aplikasi mobile tetap akurat.

* **AC-1 (Validation):** Sistem melakukan validasi ekstensi file yang diunggah. Hanya file `.gpx` yang diterima; file dengan ekstensi lain akan memicu pesan "Format file ditolak".
* **AC-2 (Safety):** Saat melakukan penghapusan data gunung atau rute, sistem wajib menampilkan dialog konfirmasi (*Double Confirmation*) untuk mencegah kehilangan data akibat kesalahan klik.

### US-07: Verifikasi Check-in Scanner (Basecamp Staff)
**Sebagai** Basecamp Staff,  
**Saya ingin** memindai QR Code pada e-ticket pendaki,  
**Agar** proses verifikasi di lapangan berjalan cepat.

* **AC-1 (Normal):** Sistem mengubah status sesi pendakian menjadi "On Track" sesaat setelah QR Code yang valid berhasil dipindai.
* **AC-2 (Error - Invalid Ticket):** Jika QR Code tidak terdaftar, sudah kedaluwarsa, atau sudah pernah digunakan, sistem menampilkan indikator visual berwarna merah dengan pesan kesalahan yang spesifik.

### US-08: Manajemen Jalur Lokal (Basecamp Staff)
**Sebagai** Basecamp Staff,  
**Saya ingin** memperbarui status operasional jalur yang ditugaskan,  
**Agar** pendaki mendapatkan informasi terkini mengenai kondisi jalur.

* **AC-1 (Normal):** Staff dapat mengubah status jalur menjadi "Buka", "Tutup Sementara", atau "Peringatan Cuaca Buruk".
* **AC-2 (Error - Connection Failure):** Jika terjadi kegagalan koneksi saat melakukan update, sistem menampilkan pesan "Gagal memperbarui status rute, silakan coba lagi" dan tidak mengubah data sebelumnya.
