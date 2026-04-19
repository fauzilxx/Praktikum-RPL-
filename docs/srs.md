# Software Requirements Specification (SRS) - ALTIGUIDE

## 1. Pendahuluan
Dokumen ini berisi spesifikasi kebutuhan perangkat lunak untuk aplikasi **ALTIGUIDE**, sebuah platform navigasi dan manajemen pendaftaran pendakian gunung.

---

## 2. Deskripsi Umum
ALTIGUIDE dirancang untuk memudahkan pendaki dalam:
- Melakukan pendaftaran (Simaksi) secara online  
- Memantau cuaca  
- Mendapatkan panduan navigasi offline  

---

## 3. Kebutuhan Fungsional (Functional Requirements)

### Fitur Inti: Manajemen Pendaftaran & Verifikasi Simaksi (Must-Have)

#### FR-01
Sistem menyediakan formulir digital bagi Pendaki untuk mengisi data diri dan memilih tanggal pendakian.  
- **Prioritas:** High  
- **Ref:** US-01  

#### FR-02
Sistem menyediakan informasi detail fasilitas dari setiap basecamp di gunung yang tersedia dan kontak basecamp.  
- **Prioritas:** High  
- **Ref:** US-03  

#### FR-03
Sistem menampilkan visualisasi prediksi cuaca dan suhu di area gunung untuk jangka waktu 3 hari ke depan.  
- **Prioritas:** Medium  
- **Ref:** US-05  

#### FR-04
Sistem menyediakan dasbor khusus bagi Admin untuk mengelola dan memperbarui data informasi basecamp.  
- **Prioritas:** High  
- **Ref:** US-02  

#### FR-05
Sistem memperbarui sisa kuota gunung secara real-time dan mengubah status pendaki menjadi **"Disetujui"** setelah verifikasi Admin selesai.  
- **Prioritas:** High  
- **Ref:** US-02  

---

### Fitur Pendukung (Supporting Features)

#### FR-06
Sistem menyediakan fitur unduhan peta jalur pendakian agar dapat digunakan dalam kondisi tanpa koneksi internet.  
- **Prioritas:** Low  
- **Ref:** US-07  

---

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)

#### NFR-01: Performance
Waktu respons (*response time*) dari API untuk memuat data teks fasilitas basecamp dan cuaca tidak melebihi **3 detik** saat diakses menggunakan koneksi internet standar (3G/4G/Wi-Fi).

#### NFR-02: Security
Pengiriman data formulir pendaftaran harus dilindungi dengan enkripsi protokol **HTTPS**.

#### NFR-03: Scalability
Sistem backend harus mampu menangani:
- Hingga **100 permintaan serentak (concurrent requests)**
- Tanpa latency rata-rata lebih dari **3 detik**
- Tanpa adanya permintaan yang gagal (**0% error rate**)

---

## 5. Catatan & Asumsi
- Fitur navigasi bergantung pada sensor **GPS** yang aktif pada perangkat pengguna.  
- Sistem membutuhkan koneksi internet untuk sinkronisasi data kuota dan cuaca sebelum mode offline digunakan.  