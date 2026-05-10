# AltiGuide Android — GitHub Copilot Instructions

> This file is the definitive context document for GitHub Copilot working on the AltiGuide Android project.
> Backend is a Laravel 13 REST API. Mobile client uses Jetpack Compose + Kotlin.

---

## 1. Project Overview

- **App Name** : AltiGuide
- **Platform** : Android (Jetpack Compose)
- **Purpose** : Mobile companion app for mountain hikers in Central Java, Indonesia. Provides:
    - Complete mountain & route encyclopedia with offline navigation (GPS waypoints)
    - Real-time weather for peaks and basecamps (via backend Open-Meteo integration)
    - Shared account with web — transaction history, hiking history, and e-ticket PDF download all sync automatically from the same database
    - Offline map caching using Room Database for navigation without internet
- **Backend** : Laravel 13 REST API (separate project — `altiguide-web`)
- **Database** : PostgreSQL (accessed only via API — Android does NOT connect to DB directly)
- **Auth** : Laravel Sanctum — Bearer token stored in DataStore Preferences

---

## 2. Mobile Feature Scope

### ✅ Mobile Has (Android-exclusive)
- Offline navigation with cached GPX waypoints (Room DB)
- Real-time GPS tracking on hiking route map
- Compass and altitude display

### ✅ Shared with Web (same account, same data)
- User registration & login (1 account works on both platforms)
- View transaction history (bookings created from web appear in mobile)
- Download & view E-ticket PDF per transaction
- View hiking session history
- View mountain & route details with weather
- Update profile (name, phone, address, emergency contact)
- Forgot password (OTP via email), change password

### ❌ Mobile Does NOT Have (web-only)
- Booking / creating new transactions (this is done on the web)
- Admin panel & CMS
- E-ticket generation
- Basecamp check-in scanning

---

## 3. Tech Stack (Android)

```
Language        : Kotlin
UI Framework    : Jetpack Compose
Min SDK         : 24 (Android 7.0)
Target SDK      : 34 (Android 14)
Architecture    : MVVM (ViewModel + StateFlow + Repository)
HTTP Client     : Retrofit2 + OkHttp3 + Gson Converter
Local Storage   : Room Database (offline waypoints cache)
Auth Storage    : DataStore Preferences (stores Bearer token persistently)
Async           : Kotlin Coroutines + Flow
Navigation      : Navigation Compose
Maps            : Google Maps Compose (or OSMDroid for offline)
Dependency Inj  : Hilt (Dagger Hilt)
```

---

## 4. Backend API — Base URL

```
Development (Emulator)  : http://10.0.2.2:8000
Development (Real Device): http://192.168.x.x:8000   ← use your PC's local IP
Production              : https://[your-domain].com   ← TBD

All API endpoints are prefixed with /api automatically.
```

> **IMPORTANT**: Never use `127.0.0.1` or `localhost` — Android emulators use `10.0.2.2` to reach the host machine's localhost.

---

## 5. Authentication — Sanctum Bearer Token

- **Login** → `POST /api/login` → returns `{ token: "1|abc..." }`
- Store token in **DataStore Preferences** (NOT SharedPreferences, NOT memory only)
- Attach to **every protected request** as header: `Authorization: Bearer <token>`
- **Logout** → `POST /api/logout` → deletes current token on server → clear token from DataStore

### Required Headers for ALL requests:
```
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>   ← only for protected routes
```

---

## 6. Complete API Endpoint Reference

### 🔓 PUBLIC — No auth required

#### Register
```
POST /api/register
Body: {
  "name": "string (max 100)",
  "email": "string (valid email, unique)",
  "password": "string (min 8)",
  "password_confirmation": "string (must match password)",
  "phone_number": "string (max 15)",
  "age": "integer (1–120)",
  "address": "string",
  "emergency_contact": "string (max 15)",
  "nik": "string (exactly 16 digits, unique)"
}
Response 201: { "message": "...", "user": {...}, "token": "1|abc..." }
```

#### Login
```
POST /api/login
Body: { "email": "string", "password": "string" }
Response 200: { "message": "Login berhasil!", "user": {...}, "token": "1|abc..." }
Response 401: { "message": "Email atau password salah." }
```

#### List All Mountains
```
GET /api/mountains
Response 200: [ { "id", "name", "description", "altitude", "latitude", "longitude",
                  "province", "image_url", "routes": [...] } ]
```

#### Mountain Detail (includes routes + waypoints)
```
GET /api/mountains/{id}
Response 200: {
  "id", "name", "description", "altitude", "latitude", "longitude",
  "province", "image_url",
  "routes": [
    {
      "id", "name", "difficulty" (easy|moderate|hard), "distance_km",
      "duration_hours", "daily_quota", "latitude", "longitude",
      "route_info": { "basecamp_name", "basecamp_altitude", "simaksi_price",
                      "facilities", "contact_person", "notes",
                      "ojek_price", "ojek_description" },
      "waypoints": [
        { "id", "route_id", "name", "altitude", "order_index",
          "distance_from_prev", "estimated_time_minutes",
          "description", "has_water_source" }
      ]
    }
  ]
}
```

#### Mountain Weather (peak altitude)
```
GET /api/mountains/{id}/weather
Response 200: {
  "status": "success",
  "mountain_name": "Gunung Merbabu",
  "data": {
    "current_weather": { "temperature": 12.5, "windspeed": 20.3, "weathercode": 3 },
    "daily": { "temperature_2m_max": [...], "temperature_2m_min": [...], "weathercode": [...] }
  }
}
Response 400: { "status": "error", "message": "Koordinat gunung belum disetel di database." }
```

#### List All Routes
```
GET /api/routes
Response 200: [ { "id", "name", "mountain": {...}, "route_info": {...} } ]
```

#### Route Detail (includes waypoints for navigation)
```
GET /api/routes/{id}
Response 200: {
  "id", "name", "difficulty", "distance_km", "duration_hours", "daily_quota",
  "latitude", "longitude",
  "mountain": { "id", "name", "altitude", ... },
  "route_info": { ... },
  "waypoints": [
    { "id", "name", "altitude", "order_index", "distance_from_prev",
      "estimated_time_minutes", "description", "has_water_source" }
  ]
}
```

#### Route Weather (basecamp altitude)
```
GET /api/routes/{id}/weather
Response 200: {
  "status": "success",
  "route_name": "Via Selo",
  "basecamp_altitude": 1450,
  "data": { ... same structure as mountain weather ... }
}
```

#### Forgot Password — Step 1: Send OTP
```
POST /api/forgot-password/send-code
Body: { "email": "string (must exist in DB)" }
Response 200: { "message": "Kode verifikasi telah dikirim ke email kamu." }
Response 422: { "message": "...", "errors": { "email": ["Email tidak ditemukan..."] } }
```

#### Forgot Password — Step 2: Verify OTP
```
POST /api/forgot-password/verify-code
Body: { "email": "string", "code": "string (6 digits)" }
Response 200: { "message": "Kode terverifikasi! Silakan buat password baru." }
Response 422: { "message": "Kode tidak valid atau sudah kedaluwarsa." }
```

#### Forgot Password — Step 3: Reset Password
```
POST /api/forgot-password/reset
Body: {
  "email": "string",
  "code": "string (6 digits, must be verified first)",
  "password": "string (min 8)",
  "password_confirmation": "string"
}
Response 200: { "message": "Password berhasil direset! Silakan login." }
Response 422: { "message": "Kode tidak valid, sudah dipakai, atau sudah kedaluwarsa." }
```

---

### 🔐 PROTECTED — Requires `Authorization: Bearer <token>`

#### Logout
```
POST /api/logout
Response 200: { "message": "Logout berhasil!" }
```

#### Get Profile
```
GET /api/user
Response 200: {
  "id": "uuid",
  "name": "string",
  "email": "string",
  "phone_number": "string|null",
  "age": "integer|null",
  "address": "string|null",
  "emergency_contact": "string|null",
  "nik": "string|null"
}
```

#### Update Profile (partial update — all fields optional)
```
PUT /api/user/profile
Body (all optional): {
  "name": "string (max 100)",
  "phone_number": "string (max 15)",
  "age": "integer (1–120)",
  "address": "string",
  "emergency_contact": "string (max 15)"
}
Response 200: { "message": "Profil berhasil diperbarui.", "user": {...} }
```

#### Change Password (user must be logged in)
```
PUT /api/user/password
Body: {
  "current_password": "string",
  "password": "string (min 8)",
  "password_confirmation": "string"
}
Response 200: { "message": "Password berhasil diubah!" }
Response 422: { "message": "Password lama tidak sesuai.", "errors": {...} }
```

#### Transaction History (all bookings made from web or mobile)
```
GET /api/transactions
Response 200: {
  "status": "success",
  "data": [
    {
      "id": "uuid",
      "order_id": "ALT-20260615-ABCDEF",
      "gross_amount": 75000,
      "status": "pending|settlement|expire",
      "payment_type": "qris|null",
      "qr_url": "https://...",
      "expiry_time": "2026-06-15T08:00:00.000000Z",
      "created_at": "...",
      "hiking_session": {
        "route": { "name": "Via Selo", "mountain": { "name": "Gunung Merbabu" } },
        "members": [...]
      }
    }
  ]
}
```

#### Transaction Detail
```
GET /api/transactions/{id}
Response 200: {
  "status": "success",
  "data": {
    ...same as list item but with full hiking_session including members...
  }
}
Response 404: transaction not found or not owned by current user
```

#### Download E-Ticket PDF
```
GET /api/transactions/{id}/pdf
Response 200: application/pdf (binary stream)
Response 403: { "status": "error", "message": "Tiket PDF hanya dapat diakses untuk transaksi yang sudah dilunasi." }

Note: status must be "settlement" to download PDF.
```

#### Validate NIK (check if a user is registered and available for a hike)
```
POST /api/validate-nik
Body: {
  "nik": "string (16 digits)",
  "start_date": "YYYY-MM-DD (today or future)",
  "hike_type": "tektok|camp"
}
Response 200: {
  "status": "success",
  "message": "NIK Valid dan siap ditambahkan ke rombongan.",
  "data": { "user_id": 1, "nik": "...", "full_name": "...", "phone_number": "...", "emergency_contact": "..." }
}
Response 404: { "status": "error", "message": "NIK tidak terdaftar!..." }
Response 422: { "status": "error", "message": "Anggota sudah memiliki jadwal pendakian aktif..." }
```

#### Hiking Session History
```
GET /api/hiking-sessions
Response 200: [
  {
    "id": "uuid",
    "group_name": "Tim Puncak",
    "start_date": "2026-06-15",
    "end_date": "2026-06-16",
    "hike_type": "camp",
    "status": "prepared|on_track|finished",
    "route": { "name": "Via Selo", "mountain": { "name": "Gunung Merbabu" } },
    "members": [...]
  }
]
```

#### Hiking Session Detail (includes full waypoints for navigation)
```
GET /api/hiking-sessions/{id}
Response 200: {
  ...session fields...,
  "route": {
    ...route fields...,
    "route_info": {...},
    "waypoints": [      ← USE THIS for offline navigation map
      { "id", "name", "altitude", "order_index", "distance_from_prev",
        "estimated_time_minutes", "description", "has_water_source" }
    ]
  },
  "members": [...],
  "transaction": {...}
}
```

---

## 7. Project Architecture (Android)

Use **MVVM** strictly. Never put business logic in Composables.

```
altiguide-android/
├── data/
│   ├── network/
│   │   ├── ApiClient.kt           # Retrofit singleton + OkHttp with auth interceptor
│   │   └── AltiGuideApiService.kt # Retrofit interface with all @GET/@POST/@PUT annotations
│   ├── model/                     # Kotlin data classes matching API JSON
│   │   ├── AuthModels.kt          # LoginRequest, RegisterRequest, AuthResponse, UserModel
│   │   ├── MountainModels.kt      # MountainModel, RouteModel, RouteInfoModel, WaypointModel
│   │   ├── TransactionModels.kt   # TransactionModel, TransactionData, CreateTransactionRequest
│   │   └── HikingSessionModels.kt # HikingSessionModel, HikingMemberModel
│   ├── local/
│   │   ├── AltiGuideDatabase.kt   # Room Database definition
│   │   ├── entity/
│   │   │   ├── CachedRoute.kt     # @Entity for offline route cache
│   │   │   └── CachedWaypoint.kt  # @Entity for offline waypoint cache
│   │   └── dao/
│   │       ├── RouteDao.kt        # DAO for cached routes
│   │       └── WaypointDao.kt     # DAO for cached waypoints
│   └── repository/
│       ├── AuthRepository.kt      # Login, logout, profile operations
│       ├── MountainRepository.kt  # Mountains + weather
│       ├── RouteRepository.kt     # Routes + waypoints + offline cache
│       └── TransactionRepository.kt # Transactions + hiking sessions
├── ui/
│   ├── auth/
│   │   ├── LoginScreen.kt
│   │   ├── RegisterScreen.kt
│   │   ├── ForgotPasswordScreen.kt
│   │   └── AuthViewModel.kt
│   ├── home/
│   │   ├── HomeScreen.kt          # Mountain list
│   │   └── HomeViewModel.kt
│   ├── mountain/
│   │   ├── MountainDetailScreen.kt
│   │   └── MountainViewModel.kt
│   ├── navigation/
│   │   ├── NavigationScreen.kt    # Offline map + GPS tracking
│   │   └── NavigationViewModel.kt
│   ├── transaction/
│   │   ├── TransactionListScreen.kt
│   │   ├── TransactionDetailScreen.kt
│   │   └── TransactionViewModel.kt
│   └── profile/
│       ├── ProfileScreen.kt
│       └── ProfileViewModel.kt
├── util/
│   ├── DataStore.kt               # Token persistence helpers
│   └── UiState.kt                 # sealed class: Idle | Loading | Success<T> | Error
└── di/
    └── AppModule.kt               # Hilt module: provides Retrofit, Database, Repositories
```

---

## 8. UiState Pattern (use everywhere)

```kotlin
sealed class UiState<out T> {
    object Idle : UiState<Nothing>()
    object Loading : UiState<Nothing>()
    data class Success<T>(val data: T) : UiState<T>()
    data class Error(val message: String) : UiState<Nothing>()
}
```

---

## 9. Token Management Rules

```kotlin
// Keys
val TOKEN_KEY = stringPreferencesKey("auth_token")

// Save after login
suspend fun saveToken(context: Context, token: String) {
    context.dataStore.edit { it[TOKEN_KEY] = token }
}

// Read on app start (inject into ApiClient.authToken)
val token = context.dataStore.data.map { it[TOKEN_KEY] ?: "" }.first()

// Clear on logout
suspend fun clearToken(context: Context) {
    context.dataStore.edit { it.remove(TOKEN_KEY) }
}
```

---

## 10. Offline Navigation — Room Cache Strategy

Waypoints are fetched from `GET /api/routes/{id}` (when online) and cached in Room DB.
On navigation screen, always read from Room first, sync from API if stale (older than 24h).

```kotlin
@Entity(tableName = "cached_waypoints")
data class CachedWaypoint(
    @PrimaryKey val id: Int,
    val routeId: Int,
    val name: String,
    val altitude: Int?,
    val orderIndex: Int,
    val distanceFromPrev: Double?,
    val estimatedTimeMinutes: Int?,
    val description: String?,
    val hasWaterSource: Boolean,
    val cachedAt: Long = System.currentTimeMillis()
)
```

---

## 11. Error Handling Rules

- Always wrap API calls in try-catch
- Map HTTP errors to UiState.Error with Indonesian messages
- Common codes:
    - `401` → Token expired → clear token → navigate to Login
    - `422` → Validation error → show `errors` field from JSON response
    - `404` → Resource not found → show "Data tidak ditemukan"
    - `500` → Server error → show "Terjadi kesalahan pada server"
    - `IOException` → Network error → show "Tidak ada koneksi internet"

---

## 12. Data Models Reference

### UserModel
```kotlin
data class UserModel(
    val id: String,           // UUID
    val name: String,
    val email: String,
    val phone_number: String?,
    val age: Int?,
    val address: String?,
    val emergency_contact: String?,
    val nik: String?
)
```

### MountainModel
```kotlin
data class MountainModel(
    val id: Int,
    val name: String,
    val description: String?,
    val altitude: Int?,       // in meters (mdpl)
    val latitude: Double?,
    val longitude: Double?,
    val province: String?,
    val image_url: String?,
    val routes: List<RouteModel>?
)
```

### RouteModel
```kotlin
data class RouteModel(
    val id: Int,
    val mountain_id: Int,
    val name: String,
    val difficulty: String?,  // "easy" | "moderate" | "hard"
    val distance_km: Double?,
    val duration_hours: Double?,
    val daily_quota: Int?,
    val latitude: Double?,
    val longitude: Double?,
    val mountain: MountainModel?,
    val route_info: RouteInfoModel?,
    val waypoints: List<WaypointModel>?
)
```

### RouteInfoModel
```kotlin
data class RouteInfoModel(
    val id: Int,
    val route_id: Int,
    val basecamp_name: String?,
    val basecamp_altitude: Int?,
    val simaksi_price: Int?,       // in IDR (Rupiah)
    val facilities: String?,
    val contact_person: String?,
    val notes: String?,
    val ojek_price: Int?,           // transport price to basecamp
    val ojek_description: String?   // transport details
)
```

### WaypointModel
```kotlin
data class WaypointModel(
    val id: Int,
    val route_id: Int,
    val name: String,
    val altitude: Int?,             // in meters
    val order_index: Int,           // use this for ordering, NOT id
    val distance_from_prev: Double?,// in km from previous waypoint
    val estimated_time_minutes: Int?,
    val description: String?,
    val has_water_source: Boolean
)
```

### TransactionModel
```kotlin
data class TransactionModel(
    val id: String,           // UUID
    val order_id: String,     // e.g. "ALT-20260615-ABCDEF"
    val gross_amount: Int,    // in IDR
    val status: String,       // "pending" | "settlement" | "expire"
    val payment_type: String?,
    val qr_url: String?,
    val expiry_time: String?,
    val created_at: String?,
    val hiking_session: HikingSessionModel?
)
```

### HikingSessionModel
```kotlin
data class HikingSessionModel(
    val id: String,           // UUID
    val leader_id: String,
    val route_id: Int,
    val transaction_id: String,
    val group_name: String,
    val start_date: String?,  // "YYYY-MM-DD"
    val end_date: String?,
    val hike_type: String?,   // "tektok" | "camp"
    val status: String,       // "prepared" | "on_track" | "finished"
    val route: RouteModel?,
    val members: List<HikingMemberModel>?,
    val transaction: TransactionModel?
)
```

---

## 13. Backend Database Quick Reference

These tables exist in the backend PostgreSQL database. Android accesses them ONLY via the API above.

| Table | Key Fields |
|---|---|
| `users` | UUID pk, name, email, nik (16 digits), phone_number, age, address, emergency_contact |
| `mountains` | int pk, name, slug, altitude (mdpl), latitude, longitude, province, status (open/closed/alert) |
| `routes` | int pk, mountain_id, name, slug, difficulty (easy/moderate/hard), distance_km, daily_quota |
| `route_infos` | int pk, route_id (1:1), basecamp_name, basecamp_altitude, simaksi_price, ojek_price, facilities |
| `route_waypoints` | int pk, route_id, name, altitude, order_index, distance_from_prev, estimated_time_minutes, has_water_source |
| `transactions` | UUID pk, user_id, order_id, gross_amount, status (pending/settlement/expire), qr_url, expiry_time |
| `hiking_sessions` | UUID pk, leader_id, route_id, transaction_id, group_name, start_date, end_date, hike_type, status |
| `hiking_members` | UUID pk, hiking_session_id, user_id, identity_number, full_name, phone_number, emergency_contact |

**8 Mountains seeded**: Ungaran, Merbabu, Slamet, Lawu, Sindoro, Sumbing, Andong, Prau
**34 Routes** with complete basecamp info and ojek transport data
**205 Waypoints** with altitude, distance, time estimates, and water source flags

---

## 14. Code Conventions (Android/Kotlin)

```
- Use Kotlin idioms: data classes, sealed classes, extension functions, let/run/also
- Follow MVVM strictly — Composables only call ViewModel functions, never Repository directly
- StateFlow for UI state, SharedFlow for one-time events (navigation, toast)
- Use `collectAsState()` in Composables to observe StateFlow
- Name ViewModels: [Feature]ViewModel (e.g. MountainViewModel, ProfileViewModel)
- Name Screens: [Feature]Screen (e.g. MountainDetailScreen, TransactionListScreen)
- Always show loading indicator while API is in-flight
- Always show error state with retry option
- Format currency as: "Rp ${NumberFormat.getInstance(Locale("id","ID")).format(amount)}"
- Date format for display: "dd MMMM yyyy" using Indonesian locale
- Order waypoints by order_index, NOT by id
```

---

## 15. AndroidManifest Requirements

```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.ACCESS_FINE_LOCATION" />
<uses-permission android:name="android.permission.ACCESS_COARSE_LOCATION" />

<!-- Development only — remove for production with HTTPS -->
<application android:usesCleartextTraffic="true"....>
```

---

## 16. Do NOT

```
- Do NOT connect to PostgreSQL database directly from Android
- Do NOT store Bearer token in SharedPreferences (use DataStore instead)
- Do NOT put API base URL as http://127.0.0.1 or http://localhost (use 10.0.2.2 for emulator)
- Do NOT skip the Authorization header on protected endpoints
- Do NOT order waypoints by id — always use order_index
- Do NOT call booking/transaction creation from mobile — that's web-only
- Do NOT use String for monetary amounts — use Int (IDR has no decimal)
- Do NOT assume transaction.hiking_session is always non-null (may be null in list view)
- Do NOT cache user credentials — only cache the Bearer token
- Do NOT expose any backend server keys in Android code
```

---

*Last updated: 2026-05-10. Backend: altiguide-web (Laravel 13 + PostgreSQL). All 26 API endpoints documented above are production-ready.*
