# AltiGuide Mobile - Backend & Architecture Setup Documentation

Dokumen ini berisi rangkuman seluruh pengaturan struktur proyek dan *Backend Layer* (Data & Domain) yang telah dikonfigurasi pada aplikasi Android AltiGuide untuk memenuhi persyaratan dari `copilot-instruction.md`.

## 1. Arsitektur Proyek
Aplikasi ini dibangun menggunakan arsitektur **MVVM (Model-View-ViewModel)** dengan pemisahan *concern* yang jelas:
- **Data Layer:** Model, Network (Retrofit), Local/Cache (Room Database).
- **Repository Layer:** Kelas sebagai jembatan (sumber kebenaran tunggal) antara Data Layer dan UI.
- **UI Layer:** (Mendatang) Compose + ViewModel.

Depedensi diinjeksi secara otomatis menggunakan **Dagger Hilt**.

## 2. Struktur Library & Konfigurasi (Gradle)
Untuk menjaga kompatibilitas API, mencegah *error build*, dan mendukung integrasi Hilt yang stabil:
- **Android Gradle Plugin (AGP):** `8.3.2`
- **Compile/Target SDK:** `35` (Mendukung stabilitas versi Jetpack di AGP 8).
- **Core Dependencies:** 
  - `Retrofit2 & OkHttp3` untuk API Networking.
  - `Room Database` untuk navigasi *offline/cache*.
  - `DataStore Preferences` untuk manajemen sesi/token aman.
  - `Dagger Hilt` untuk *Dependency Injection*.

## 3. Komponen yang Dibuat

### A. Application & Core
- **`AltiGuideApplication.kt`**: Kelas aplikasi utama dengan anotasi `@HiltAndroidApp` untuk memicu *code-generation* *Dependency Injection*.
- **`AndroidManifest.xml`**: Penambahan permission `INTERNET`, `ACCESS_FINE_LOCATION`, `ACCESS_COARSE_LOCATION`, dan aktivasi `usesCleartextTraffic="true"` untuk testing API localhost (`10.0.2.2`).

### B. Utilities (`/util`)
- **`UiState.kt`**: *Sealed class* (`Idle`, `Loading`, `Success`, `Error`) sebagai standar baku pengiriman state dari ViewModel ke antarmuka Compose.
- **`DataStore.kt`**: `AuthDataStore` untuk memonitor (*Flow*), menyimpan, dan menghapus `auth_token` (*Bearer Token*) secara gigih.

### C. Dependency Injection (`/di`)
- **`AppModule.kt`**: Modul injeksi Hilt tersentralisasi yang menyuplai:
  - `AuthDataStore` (menyediakan referensi state login lokal).
  - `OkHttpClient` berserta **Interceptor** keamanan (yang otomatis menyisipkan header `Authorization: Bearer <token>` pada setiap pemanggilan API).
  - `Retrofit` & `AltiGuideApiService` (beralamat pusat di `http://10.0.2.2:8000/`).
  - `AltiGuideDatabase` (pemanggil basis data lokal Room).

### D. Data Models (`/data/model`)
Semua objek disusun berdasarkan referensi respons Backend Laravel:
- **`AuthModels.kt`**: `UserModel`, representasi request login/register, dan `AuthResponse`.
- **`MountainModels.kt`**: `MountainModel`, struktur informasi gunung, cuaca (`WeatherResponse`), jalur (`RouteModel`), *basecamp*, dan titik daki/waypoint.
- **`TransactionModels.kt`**: `TransactionModel`, respons histori riwayat pembayaran dan status e-ticket.
- **`HikingSessionModels.kt`**: `HikingSessionModel` kelas yang menghimpun ketua grup, status rute pendakian, dan array `HikingMemberModel`.

### E. Network/API Interfaces (`/data/network`)
- **`AltiGuideApiService.kt`**: Pemetaan 20+ URL Endpoint dengan metode HTTP (GET/POST/PUT) yang dibungkus sinkron dengan *Kotlin Coroutines* (`suspend fun`), antara lain API Auth, get Mountains, Route Weather, PDF e-ticket, dst.

### F. Local Database (Room) (`/data/local`)
Subsistem ini mempfasilitasi **Navigasi Offline**:
- **Entity**: `CachedRoute.kt` dan `CachedWaypoint.kt` (berisi lintang bujur rute serta *index* jalurnya).
- **DAO**: `RouteDao.kt` dan `WaypointDao.kt` (Kueri relasional insert & penarikan berformat koleksi `Flow`).
- **Database**: `AltiGuideDatabase.kt` sebagai konfigurator utama.

### G. Repositories (`/data/repository`)
Sistem tidak pernah memanggil API maupun Room langsung dari UI; ia menggunakan Repository:
- **`AuthRepository.kt`**: Memanggil proses Login/Register, lalu otomatis menulis token ke DataStore. Saat logout, ia menjamin DataStore turut dikosongkan.
- **`MountainRepository.kt`**: Mengambil daftar & merinci info Gunung berserta prakiraan Cuaca Harian.
- **`RouteRepository.kt`**: **Dilengkapi mekanisme pintar Offline-Sync.** Waktu pengguna merinci sebuah rute (`getRouteDetail(id, syncToLocal=true)`), sistem akan mengambilnya ke server, dan secepatnya menyimpan/menimpa database internal HP (keseluruhan titik *Waypoints*) di `Room`. Method `getCachedRoute()` & `getCachedWaypoints()` disajikan khusus guna keperluan pelacakan layar saat pengguna tidak mendapat sinyal.
- **`TransactionRepository.kt`**: Mendapatkan status pendakian terakhir dan men-*download* berkas respon dalam `ResponseBody` PDF.

---
## Langkah Berikutnya
Data Layer telah kokoh dan terverifikasi bisa dikompilasi dengan baik (*build success*). Apabila pengembangan *Backend* sudah dianggap komplet, kita bisa masuk ke **Presentation Layer**:
1. Merancang `AuthViewModel` & layar `LoginScreen.kt` menggunakan *Jetpack Compose*.
2. Membangun setup *Navigation Controller Compose* di halaman awal guna menyambungkan layar masuk ke Dashboard aplikasi.

