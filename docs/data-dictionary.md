# Laporan Struktur Kamus Data (*Data Dictionary*)
**Proyek:** Sistem Informasi Pendakian Gunung (AltiGuide Web)  
**Tanggal:** 20 April 2026  

### 1. Tabel `users` (Akses Publik / Pendaki)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `UUID` | **PK** | ID unik pendaki pengguna sistem. |
| name | `VARCHAR(100)` | INDEX | Nama pengguna. |
| email | `VARCHAR(150)` | UNIQUE | Alamat email registrasi utama. |
| password | `VARCHAR` | - | Kata sandi (terenkripsi *hashed*). |
| phone_number | `VARCHAR(15)` | - | Nomor kontak WhatsApp/Telepon. |
| age | `SMALLINT` | - | Umur pengguna. |
| address | `TEXT` | - | Alamat sesuai data. |
| emergency_contact| `VARCHAR(15)` | - | Nomor darurat jika insiden terjadi. |
| nik | `VARCHAR(16)` | UNIQUE | Nomor Identitas KTP. |

### 2. Tabel `admins` (Akses Manajemen)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `UUID` | **PK** | Kunci utama / Identifikasi staff. |
| name | `VARCHAR(100)` | - | Nama petugas. |
| email | `VARCHAR(150)` | UNIQUE | Email staf untuk masuk sistem. |
| password | `VARCHAR` | - | Kata sandi staf (terenkripsi). |
| role | `ENUM` | - | `'superadmin'`, `'developer'`, `'basecamp_staff'`. |
| route_id | `BIGINT` | **FK** (Nullable) | Bertugas di Rute mana (`routes (id)`) jika perannya Basecamp. |
| is_active | `BOOLEAN` | DEFAULT true | Menentukan apakah staf tersebut masih aktif/kerja. |

### 3. Tabel `mountains`
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `BIGINT` | **PK** (Auto Inc)| Kunci utama gunung. |
| name | `VARCHAR(100)` | - | Nama gunung tersebut. |
| slug | `VARCHAR(255)` | UNIQUE | Format untuk link/URL halaman. |
| location | `VARCHAR(100)` | - | Kabupaten atau provinsi posisi rupa bumi. |
| altitude | `INTEGER` | - | Tinggi puncak (Dalam satuan MDPL). |
| description | `TEXT` | NULLABLE | Penjabaran informatif rupa bumi. |
| latitude | `DECIMAL(10,8)`| NULLABLE | Titik pemetaan Lintang peta. |
| longitude | `DECIMAL(11,8)`| NULLABLE | Titik pemetaan Bujur peta. |
| image | `VARCHAR` | NULLABLE | Nama file/direktori poster media. |
| status | `ENUM` | DEFAULT 'open' | Status kelayakan (`'open'`, `'closed'`, `'alert'`). |
| created_by | `UUID` | **FK** (Nullable) | Merujuk ID admin (`admins (id)`). |

### 4. Tabel `routes` (Jalur)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `BIGINT` | **PK** (Auto Inc)| Kunci utama. |
| mountain_id | `BIGINT` | **FK** | Memilih gunung mana (`mountains (id)`). |
| name | `VARCHAR(100)` | - | Spesifik nama pos masuk. |
| slug | `VARCHAR` | UNIQUE | Format unik untuk keperluan URL pengunjung. |
| distance | `DECIMAL(8,2)` | - | Kilometer panjang jelajah dari bawah. |
| estimated_time | `INTEGER` | - | Durasi normal penjelajahan (menit). |
| difficulty | `ENUM` | - | `'easy'`, `'moderate'`, `'hard'`. |
| daily_quota | `INTEGER` | DEFAULT 70 | Batas kuota harian izin orang (SIMAKSI).|
| is_active | `BOOLEAN` | DEFAULT true | Izin khusus pintu rimba jalur dibuka/tidak. |

### 5. Tabel `route_infos`
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `BIGINT` | **PK** | ID Detail (Auto Inc). |
| route_id | `BIGINT` | **FK** (Cascade) | Menyatu dengan tabel jalur pendakian utama. |
| basecamp_address| `TEXT` | NULLABLE | Panduan lokasi Basecamp. |
| basecamp_altitude| `INTEGER` | NULLABLE | Titik ketinggian titik masuk Basecamp MDPL. |
| simaksi_price | `DECIMAL(10,2)`| NULLABLE | Harga dasar registrasi izin pendakian (Asuransi). |
| ojek_price | `DECIMAL(10,2)`| NULLABLE | Info tarif angkutan lokal tambahan (bila ada). |
| ojek_description| `TEXT` | NULLABLE | Info panjang jasa angkut Ojek bisa mengantar. |
| facilities_description| `TEXT` | NULLABLE| Info toilet, tempat istirahat, dsb. |

### 6. Tabel `route_waypoints` (Etape / Pos)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `BIGINT` | **PK** | ID Pos Pemberhentian. |
| route_id | `BIGINT` | **FK** (Cascade) | Milik Jalur Pendakian (`routes (id)`). |
| name | `VARCHAR(150)` | - | Nama pos (Contoh: "Pos 1", "Sumber Air Puncak"). |
| slug | `VARCHAR(255)` | UNIQUE | ID String/URL pos. |
| altitude | `INTEGER` | NULLABLE | Elevasi dari titik bersangkutan. |
| order_index | `INTEGER` | DEFAULT 0 | Nomor urutan agar teratur secara geografis. |
| distance_from_prev| `DECIMAL(6,2)` | NULLABLE | Jarak rill dari pos sebelumnya (KM). |
| estimated_time_minutes| `INTEGER` | NULLABLE | Kisaran tempuh dari pos yang barusan dilalui. |
| has_water_source| `BOOLEAN` | DEFAULT false| Petunjuk kelayakan survival berupa mata air. |
| description | `TEXT` | NULLABLE | Tips/panduan titik ini secara lebih detail. |

### 7. Tabel `transactions` (Layanan Midtrans Gateway)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `UUID` | **PK** | ID dari transaksi aplikasi (*Invoice* Internal). |
| user_id | `UUID` | **FK** | Memiliki kewajiban bagi user pendaftar (`users (id)`). |
| order_id | `VARCHAR(50)` | UNIQUE | Identitas transaksi keluar sistem (ke Midtrans Payment). |
| gross_amount | `DECIMAL(12,2)`| - | Hasil akhir hitungan harga tagihan keseluruhan. |
| qr_url | `TEXT` | NULLABLE | *Output Link/Image* jika pelanggan pakai pay QRIS. |
| payment_type | `VARCHAR(20)` | DEFAULT 'qris'| Nama Channel layanan transfernya. |
| status | `ENUM` | DEFAULT 'pending'| Keadaan uang: `'pending'`, `'settlement'`, `'expire'`. |
| transaction_id | `VARCHAR(100)`| NULLABLE | ID validasi pencocokan sah dari balasan pihak Midtrans. |
| expiry_time | `TIMESTAMP` | NULLABLE | Jam tenggat waktu penyelesaian limit bank pengguna. |

### 8. Tabel `hiking_sessions` (Pemberkasan Pendakian Regu)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `UUID` | **PK** | UUID khusus tanda terima dari tiket asuransi & perjalanan.|
| leader_id | `UUID` | **FK** | Ketua Regu / Penanggung Jawab (`users (id)`). |
| route_id | `BIGINT` | **FK** | Referensi tujuan penjelajahan alam (`routes (id)`). |
| transaction_id | `UUID` | **FK** | Mengikat rincian dengan tiket biaya pada `transactions`. |
| group_name | `VARCHAR(100)` | - | Nomenklatur/Identitas Kelompok. |
| start_date | `DATE` | - | Perkiraan penanggalan tiket di scan naik. |
| end_date | `DATE` | - | Perkiraan tanggal kembali di lapangan. |
| hike_type | `ENUM` | DEFAULT 'camp'| Gaya berkegiatan (`'tektok'` atau `'camp'`). |
| status | `ENUM` | DEFAULT 'prepared'| Kesiapan di sistem (`'prepared'`, `'on_track'`, `'finished'`). |

### 9. Tabel `hiking_members` (Pivot Detail Keanggotaan Sesi)
| Nama Kolom | Tipe Data | Constraint | Keterangan |
| :--- | :--- | :--- | :--- |
| **id** | `UUID` | **PK** | Serial data absensi individu. |
| hiking_session_id| `UUID` | **FK** | Regu manakah pergerakan ini disematkan. |
| user_id | `UUID` | **FK** | Member sistem manakah identitas partisipannya. |
| identity_number | `VARCHAR(50)` | - | Nomor asuransi diri/KTP spesifik ketika mendaftar. |
| full_name | `VARCHAR(100)` | - | Nama peserta asuransi (saat validasi lapak Basecamp). |
| phone_number | `VARCHAR(30)` | - | Nomor terhubung selama pelaksanaan. |
| emergency_contact| `VARCHAR(30)` | - | Alamat/Nomor Orangtua bilamana musibah di gunung ini. |
