# Peran Pengguna & User Story: AltiGuide

## 1. Peran Pengguna (User Roles)
* **Pendaki (Pengguna Utama):** Pengguna aplikasi yang melakukan pendaftaran Simaksi online, mencari informasi detail basecamp, mengecek prediksi cuaca, dan (opsional) menggunakan navigasi.
* **Admin (Pengelola/Ranger):** Pihak yang mengelola dasbor sistem untuk memverifikasi data Simaksi, memperbarui informasi basecamp, dan memantau keseluruhan data pendakian.

---

## 2. User Story & Acceptance Criteria

### US-01: Pengajuan Simaksi Online
* **Story:** As a Pendaki, I want mengajukan izin pendakian (Simaksi) secara online, so that saya tidak perlu membuang waktu mengantre di basecamp.
* **Acceptance Criteria:**
  * **Given** saya berada di menu pendaftaran, **When** saya mengisi formulir data diri dan menekan tombol "Kirim Pengajuan", **Then** sistem menampilkan status "Menunggu Verifikasi" dan nomor registrasi.

### US-02: Verifikasi Simaksi (Dasbor Admin)
* **Story:** As an Admin, I want memverifikasi pengajuan Simaksi pendaki melalui dasbor, so that saya dapat mengontrol kuota harian gunung yang bersangkutan.
* **Acceptance Criteria:**
  * **Given** saya sudah login ke dasbor admin, **When** saya menekan tombol "Terima" pada data pengajuan seorang pendaki, **Then** status pendaki tersebut berubah menjadi "Disetujui" dan kuota harian otomatis berkurang.

### US-03: Melihat Informasi Basecamp
* **Story:** As a Pendaki, I want melihat informasi lengkap terkait basecamp (fasilitas, lokasi, kontak pengelola), so that saya dapat merencanakan titik kumpul dan logistik dengan baik.
* **Acceptance Criteria:**
  * **Given** saya berada di halaman profil gunung, **When** saya memilih menu "Info Basecamp", **Then** sistem menampilkan daftar fasilitas (seperti toilet, warung, area parkir) beserta nomor kontak darurat.

### US-04: Mengelola Informasi Basecamp
* **Story:** As an Admin, I want memperbarui deskripsi dan fasilitas basecamp melalui dasbor, so that pendaki selalu mendapatkan informasi yang valid dan aktual.
* **Acceptance Criteria:**
  * **Given** saya berada di menu manajemen basecamp pada dasbor, **When** saya menambahkan fasilitas baru dan menekan "Simpan", **Then** informasi tersebut langsung terbarui di tampilan aplikasi pengguna.

### US-05: Pengecekan Prediksi Cuaca
* **Story:** As a Pendaki, I want melihat prediksi cuaca harian di area gunung, so that saya dapat menyiapkan pakaian dan perlengkapan perlindungan yang tepat.
* **Acceptance Criteria:**
  * **Given** saya membuka detail suatu gunung, **When** saya melihat bagian atas layar, **Then** sistem menampilkan ikon cuaca (misal: Hujan/Cerah) beserta perkiraan suhu untuk 3 hari ke depan.

### US-06: Ringkasan Data (Dasbor Admin)
* **Story:** As an Admin, I want melihat ringkasan total pendaki harian dan pendapatan Simaksi dalam bentuk grafik, so that saya bisa memantau efisiensi operasional dengan mudah.
* **Acceptance Criteria:**
  * **Given** saya membuka halaman utama dasbor admin, **When** halaman termuat penuh, **Then** sistem menampilkan grafik jumlah pendaki yang masuk minggu ini.

### US-07: Mengunduh Peta (Navigasi Opsional)
* **Story:** As a Pendaki, I want mengunduh peta jalur pendakian, so that saya bisa menjadikannya panduan arah cadangan saat tidak ada internet.
* **Acceptance Criteria:**
  * **Given** saya memiliki koneksi internet, **When** saya menekan tombol "Unduh Peta Offline", **Then** file peta tersimpan di perangkat dan bisa dibuka dalam mode pesawat.

### US-08: Pelacakan Lokasi (Navigasi Opsional)
* **Story:** As a Pendaki, I want melacak lokasi saya di peta yang telah diunduh, so that saya tahu letak persis saya di jalur pendakian.
* **Acceptance Criteria:**
  * **Given** GPS saya aktif dan saya berada di jalur, **When** saya membuka peta offline, **Then** posisi saya ditunjukkan dengan ikon titik biru yang sesuai dengan koordinat dunia nyata.