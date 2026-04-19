# Peran Pengguna & User Story: AltiGuide

## 1. Peran Pengguna (User Roles)
* **Pendaki (Pengguna Utama):** Pengguna aplikasi yang melakukan pendaftaran Simaksi online, mencari informasi detail basecamp, mengecek prediksi cuaca, dan (opsional) menggunakan navigasi.
* **Admin (Pengelola/Ranger):** Pihak yang mengelola dasbor sistem untuk memverifikasi data Simaksi, memperbarui informasi basecamp, dan memantau keseluruhan data pendakian.

---

## 2. User Story & Acceptance Criteria

### US-01: Pengajuan Simaksi Daring
**Sebagai** Pendaki,  
**Saya ingin** mengajukan Simaksi secara daring,  
**Agar** saya bisa mendapatkan izin mendaki dengan lebih efisien tanpa harus mengantre di lokasi.

**Acceptance Criteria:**
- **AC-1 (Normal):** Sistem menyediakan formulir yang memuat data diri, jadwal pendakian, dan unggahan dokumen identitas. Jika semua data valid, sistem menyimpan pengajuan dengan status "Pending" dan memberikan notifikasi sukses.
- **AC-2 (Error - Validasi Data):** Jika pengguna mengosongkan kolom wajib (misal: NIK atau Kontak Darurat) saat menekan tombol kirim, sistem harus menampilkan pesan error "Bagian ini wajib diisi" di bawah kolom terkait.
- **AC-3 (Error - Format File):** Jika pengguna mengunggah dokumen selain format JPG/PNG/PDF atau ukuran file >2MB, sistem harus menolak unggahan dan menampilkan pesan "Format file tidak didukung atau ukuran melebihi batas".

---

### US-02: Verifikasi Pengajuan Simaksi (Admin)
**Sebagai** Admin,  
**Saya ingin** memverifikasi pengajuan Simaksi melalui dasbor,  
**Agar** saya dapat mengelola izin pendakian sesuai dengan validitas data dan kuota jalur.

**Acceptance Criteria:**
- **AC-1 (Normal):** Admin dapat mengubah status pengajuan menjadi "Disetujui" atau "Ditolak". Perubahan status akan memicu pengiriman notifikasi otomatis kepada pendaki.
- **AC-2 (Alternatif - Kuota Penuh):** Jika kuota pada jalur dan tanggal yang dipilih sudah penuh, sistem secara otomatis menonaktifkan tombol "Setujui" dan memberikan keterangan "Kuota Penuh".
- **AC-3 (Error - Catatan Penolakan):** Jika admin memilih status "Ditolak" tanpa mengisi alasan penolakan, sistem akan mencegah penyimpanan dan meminta admin mengisi kolom alasan.

---

### US-03: Informasi Fasilitas Basecamp
**Sebagai** Pendaki,  
**Saya ingin** melihat informasi lengkap fasilitas basecamp,  
**Agar** saya bisa mempersiapkan logistik dan kebutuhan sebelum memulai pendakian.

**Acceptance Criteria:**
- **AC-1 (Normal):** Sistem menampilkan detail fasilitas (sumber air, area parkir, mushola, toilet) dan kontak pengelola pada setiap jalur pendakian yang dipilih.
- **AC-2 (Alternatif - Data Kosong):** Jika informasi fasilitas belum tersedia di database, sistem harus menampilkan pesan "Informasi fasilitas untuk jalur ini sedang diperbarui".

---

### US-04: Pengelolaan Data Fasilitas Basecamp (Admin)
**Sebagai** Admin,  
**Saya ingin** mengelola dan memperbarui data fasilitas basecamp,  
**Agar** informasi yang diterima oleh pendaki selalu akurat.

**Acceptance Criteria:**
- **AC-1 (Normal):** Admin dapat menambah, mengubah, atau menghapus informasi fasilitas pada setiap jalur pendakian melalui panel admin.
- **AC-2 (Error - Kegagalan Sinkronisasi):** Jika terjadi kegagalan koneksi saat menyimpan perubahan, sistem harus menampilkan pesan "Gagal menyimpan data, silakan periksa koneksi internet Anda" dan mempertahankan isian data pada formulir.

---

### US-05: Prediksi Cuaca Harian
**Sebagai** Pendaki,  
**Saya ingin** melihat prediksi cuaca harian di gunung,  
**Agar** saya dapat mengantisipasi kondisi cuaca buruk demi keselamatan.

**Acceptance Criteria:**
- **AC-1 (Normal):** Sistem menampilkan prakiraan cuaca (suhu, kelembapan, kondisi langit) untuk 3 hari ke depan berdasarkan data API cuaca terpercaya.
- **AC-2 (Error - API Timeout):** Jika sistem gagal mengambil data dari penyedia layanan cuaca, sistem harus menampilkan pesan "Data cuaca saat ini tidak tersedia" tanpa merusak tata letak halaman lainnya.

---

### US-06: Visualisasi Statistik Pendaftar (Admin Dashboard)
**Sebagai** Admin,  
**Saya ingin** melihat statistik pendaftaran melalui grafik di dasbor,  
**Agar** saya dapat memantau tren pendakian dan persebaran status pengajuan secara fleksibel.

**Acceptance Criteria:**
- **AC-1 (Normal):** Dasbor menampilkan **Bar Chart** untuk jumlah pendaftar per jalur dan **Pie Chart** untuk persentase status Simaksi (Pending/Disetujui/Ditolak).
- **AC-2 (Alternatif - Filter Waktu):** Sistem menyediakan opsi filter waktu (Harian, Mingguan, Bulanan) yang akan memperbarui visualisasi grafik secara dinamis tanpa memuat ulang seluruh halaman.
- **AC-3 (Normal):** Setiap grafik harus memiliki label dan legenda yang jelas untuk memudahkan pembacaan data.

---

### US-07: Unduhan Peta Jalur Offline
**Sebagai** Pendaki,  
**Saya ingin** mengunduh peta rute navigasi untuk penggunaan luring,  
**Agar** saya tetap memiliki panduan arah meskipun berada di area tanpa sinyal seluler.

**Acceptance Criteria:**
- **AC-1 (Normal):** Pengguna dapat mengunduh paket data peta rute tertentu. Sistem menampilkan progres unduhan dalam persentase.
- **AC-2 (Error - Memori Penuh):** Jika ruang penyimpanan perangkat tidak mencukupi saat proses unduh dimulai, sistem harus memberikan peringatan "Ruang penyimpanan tidak memadai untuk mengunduh peta".

---

### US-08: Pelacakan Posisi pada Peta Luring
**Sebagai** Pendaki,  
**Saya ingin** melacak posisi koordinat saya pada peta luring,  
**Agar** saya dapat memastikan pergerakan saya tetap berada di jalur resmi pendakian.

**Acceptance Criteria:**
- **AC-1 (Normal):** Sistem menampilkan indikator posisi pengguna (blue dot) secara real-time di atas garis jalur resmi pada peta.
- **AC-2 (Alternatif - Off-Route Alert):** Jika posisi pengguna terdeteksi menyimpang lebih dari 50 meter dari jalur resmi, sistem harus memberikan notifikasi peringatan "Anda berada di luar jalur!".
- **AC-3 (Error - GPS Nonaktif):** Jika sensor GPS perangkat dimatikan oleh pengguna, sistem harus menampilkan permintaan akses lokasi dengan pesan "Aktifkan GPS untuk memulai navigasi".
