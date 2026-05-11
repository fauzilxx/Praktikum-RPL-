# Peran Pengguna & User Story: AltiGuide (Revised)

## 1. Peran Pengguna (User Roles)
* **Pendaki (Hiker):** Pengguna aplikasi (Mobile/Web) yang melakukan pendaftaran, pembayaran, dan navigasi.
* **Superadmin:** Pihak yang mengelola data master (Gunung, Rute, User) melalui CMS.
* **Basecamp Staff:** Petugas lapangan yang melakukan verifikasi tiket pendaki (*Check-in*) dan memantau rute lokal.

---

## 2. User Story & Acceptance Criteria

### US-01: Pengajuan Simaksi Daring (Hiker)
**Sebagai** Pendaki, **saya ingin** mengajukan Simaksi secara daring, **agar** saya bisa mendapatkan izin mendaki dengan lebih efisien.

* **AC-1 (Normal):** Sistem menyediakan formulir data diri, jadwal, dan unggahan identitas.
* **AC-2 (Include):** Pengguna wajib mengisi data seluruh anggota rombongan (Validasi NIK) sebelum lanjut ke pembayaran.
* **AC-3 (Error - Validasi):** Jika kolom wajib kosong atau NIK tidak berjumlah 16 digit, muncul pesan error "Format data tidak valid".
* **AC-4 (Error - Format File):** Jika file dokumen >2MB atau bukan format PDF/JPG, sistem menolak unggahan.

### US-02: Verifikasi & E-Ticket (Admin/Staff)
**Sebagai** Admin, **saya ingin** memverifikasi pengajuan dan memberikan tiket, **agar** izin pendakian sesuai dengan aturan.

* **AC-1 (Normal):** Admin dapat mengubah status menjadi "Disetujui" atau "Ditolak".
* **AC-2 (Condition):** E-Ticket (PDF) hanya akan diterbitkan secara otomatis jika transaksi pembayaran telah diverifikasi (Status: Paid).
* **AC-3 (Error - Alasan):** Jika admin menolak tanpa mengisi kolom "Alasan Penolakan", sistem akan mencegah penyimpanan data.

### US-03: Informasi Fasilitas Basecamp (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat informasi lengkap fasilitas basecamp, **agar** saya bisa mempersiapkan logistik.

* **AC-1 (Normal):** Menampilkan detail sumber air, parkir, dan kontak pengelola.
* **AC-2 (Alternative):** Jika data belum diinput oleh admin, sistem menampilkan pesan "Informasi fasilitas sedang diperbarui" agar user tidak bingung.

### US-04: Pengelolaan Data Fasilitas (Admin)
**Sebagai** Admin, **saya ingin** memperbarui data fasilitas, **agar** informasi ke pendaki selalu akurat.

* **AC-1 (Normal):** Admin dapat melakukan CRUD (Tambah, Ubah, Hapus) data fasilitas jalur.
* **AC-2 (Error - Sync):** Jika koneksi internet terputus saat menyimpan, sistem menampilkan pesan "Gagal sinkronisasi" dan tidak menghapus isian data di formulir.

### US-05: Prediksi Cuaca Harian (Hiker)
**Sebagai** Pendaki, **saya ingin** melihat prediksi cuaca di rute terkait, **agar** saya bisa mengantisipasi kondisi buruk.

* **AC-1 (Normal):** Menampilkan ramalan cuaca 3 hari ke depan berdasarkan API Open-Meteo.
* **AC-2 (Error - Timeout):** Jika API gagal ditarik, sistem menampilkan data *cache* terakhir dengan keterangan "Data terakhir diperbarui pada [Waktu]".

### US-06: Statistik Pendaftar / Dashboard (Admin)
**Sebagai** Admin, **saya ingin** melihat grafik pendaftaran, **agar** dapat memantau tren pendakian.

* **AC-1 (Filtering):** Tersedia filter berdasarkan rentang waktu (Harian, Mingguan, Bulanan).
* **AC-2 (Visualisasi):** Menggunakan Bar Chart untuk jumlah pendaftar per jalur. Grafik wajib memiliki legenda dan label sumbu yang jelas.
* **AC-3 (Clarity):** Saat *hover* pada grafik, muncul *tooltip* yang menunjukkan angka pasti pendaftar.

### US-07: Unduhan Peta Jalur Offline (Hiker)
**Sebagai** Pendaki, **saya ingin** mengunduh peta rute navigasi, **agar** tetap memiliki panduan arah tanpa sinyal.

* **AC-1 (Normal):** Menampilkan progres bar unduhan dalam persentase (%).
* **AC-2 (Error - Memory):** Jika sisa memori ponsel <100MB, sistem membatalkan unduhan dan memberikan peringatan "Penyimpanan tidak cukup".

### US-08: Pelacakan Posisi / Navigasi (Hiker)
**Sebagai** Pendaki, **saya ingin** melacak posisi saya pada peta luring, **agar** tetap berada di jalur resmi.

* **AC-1 (Normal):** Indikator posisi (blue dot) muncul secara real-time di atas jalur GPX.
* **AC-2 (Error - GPS):** Jika sensor GPS mati, muncul dialog "Mohon aktifkan lokasi untuk memulai navigasi".
* **AC-3 (Alternative):** Jika pendaki menyimpang >50 meter dari jalur, aplikasi memberikan peringatan suara/notifikasi "Anda keluar jalur".
