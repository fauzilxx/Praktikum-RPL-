# Software Requirements Specification (SRS) - ALTIGUIDE

## 1. Pendahuluan
Dokumen ini berisi spesifikasi kebutuhan perangkat lunak untuk aplikasi ALTIGUIDE, sebuah platform navigasi dan manajemen pendaftaran pendakian gunung.

## 2. Deskripsi Umum
ALTIGUIDE dirancang untuk memudahkan pendaki dalam melakukan pendaftaran (Simaksi) secara online, memantau cuaca, serta memberikan panduan navigasi offline.

## 3. Kebutuhan Fungsional (Functional Requirements)
Sesuai dengan fitur inti (Must Have), berikut adalah 5 kebutuhan fungsional sistem:

| ID FR | Deskripsi Aksi Sistem | Prioritas | Ref |
| :--- | :--- | :--- | :--- |
| **FR-01** | Sistem menyediakan formulir input data diri dan validasi kuota harian untuk pengajuan Simaksi online. | High | US-01 |
| **FR-02** | Sistem memungkinkan Admin untuk mengubah status pendaftaran menjadi "Disetujui" dan otomatis memotong sisa kuota. | High | US-02 |
| **FR-03** | Sistem menampilkan informasi detail fasilitas basecamp dan kontak darurat kepada pengguna. | Medium | US-03 |
| **FR-04** | Sistem menyajikan visualisasi prediksi cuaca dan suhu di area gunung untuk jangka waktu 3 hari ke depan. | Medium | US-05 |
| **FR-05** | Sistem menyediakan fitur pengunduhan peta jalur pendakian untuk navigasi dalam mode offline. | Low | US-07 |

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)
Kebutuhan ini mendefinisikan standar kualitas dan batasan teknis sistem.

| ID NFR | Parameter Kualitas | Spesifikasi / Standar Verifikasi |
| :--- | :--- | :--- |
| **NFR-01** | **Performance** | Sistem harus mampu memuat data prediksi cuaca dalam waktu kurang dari 3 detik. |
| **NFR-02** | **Security** | Pengiriman data formulir pendaftaran harus dilindungi dengan enkripsi protokol HTTPS. |
| **NFR-03** | **Usability** | Antarmuka aplikasi harus intuitif dengan skor minimal 75 pada pengujian System Usability Scale (SUS). |

## 5. Catatan & Asumsi
- Fitur navigasi bergantung pada sensor GPS yang aktif pada perangkat pengguna.