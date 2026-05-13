package com.example.altiguide_mobile.ui.auth

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.altiguide_mobile.data.model.AuthResponse
import com.example.altiguide_mobile.data.model.LoginRequest
import com.example.altiguide_mobile.data.repository.AuthRepository
import com.example.altiguide_mobile.data.model.MountainModel
import com.example.altiguide_mobile.data.model.TransactionListResponse
import com.example.altiguide_mobile.data.model.UserModel
import com.example.altiguide_mobile.data.repository.MountainRepository
import com.example.altiguide_mobile.data.repository.RouteRepository
import com.example.altiguide_mobile.data.repository.TransactionRepository
import com.example.altiguide_mobile.util.UiState
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import retrofit2.HttpException
import java.io.IOException
import javax.inject.Inject

@HiltViewModel
class AuthViewModel @Inject constructor(
    private val authRepository: AuthRepository,
    private val mountainRepository: MountainRepository,
    private val transactionRepository: TransactionRepository,
    private val routeRepository: RouteRepository
) : ViewModel() {

    private val _loginState = MutableStateFlow<UiState<AuthResponse>>(UiState.Idle)
    val loginState: StateFlow<UiState<AuthResponse>> = _loginState.asStateFlow()

    private val _testState = MutableStateFlow<UiState<String>>(UiState.Idle)
    val testState: StateFlow<UiState<String>> = _testState.asStateFlow()

    fun testHikingSessions() {
        viewModelScope.launch {
            _testState.value = UiState.Loading
            try {
                // GET /api/hiking-sessions
                val sessions = transactionRepository.getHikingSessions()
                android.util.Log.d("API_TEST", "Hiking Sessions count: ${sessions.size}")

                if (sessions.isNotEmpty()) {
                    val firstSession = sessions.first()
                    android.util.Log.d("API_TEST", "First Session: ID=${firstSession.id}, Group=${firstSession.group_name}, Route=${firstSession.route?.name}")

                    // GET /api/hiking-sessions/{id}
                    val sessionDetail = transactionRepository.getHikingSessionDetail(firstSession.id)
                    android.util.Log.d("API_TEST", "Session Detail Route: ${sessionDetail.route?.name}")
                    
                    val waypoints = sessionDetail.route?.waypoints
                    android.util.Log.d("API_TEST", "Session Detail Waypoints Count: ${waypoints?.size ?: 0}")
                    if (!waypoints.isNullOrEmpty()) {
                        val firstWp = waypoints.first()
                        android.util.Log.d("API_TEST", "First Waypoint: Name=${firstWp.name}, Alt=${firstWp.altitude}, Index=${firstWp.order_index}")
                    }
                } else {
                    android.util.Log.d("API_TEST", "No Hiking Sessions found for this user.")
                }

                _testState.value = UiState.Success("Hiking Sessions tested successfully! Check Logcat API_TEST.")
            } catch (e: Exception) {
                android.util.Log.e("API_TEST", "Error testing Hiking Sessions: ${e.message}", e)
                _testState.value = UiState.Error("Test failed: ${e.message}")
            }
        }
    }

    fun testWeather() {
        viewModelScope.launch {
            _testState.value = UiState.Loading
            try {
                // Test Mountain Weather (e.g., Mount ID = 2 for Merbabu)
                val mountainWeather = mountainRepository.getMountainWeather(2)
                android.util.Log.d("API_TEST", "Mountain Weather: ${mountainWeather.mountain_name}, Status: ${mountainWeather.status}")
                if (mountainWeather.data != null) {
                    android.util.Log.d("API_TEST", "Peak Current Temp: ${mountainWeather.data.current_weather.temperature}°C, Wind: ${mountainWeather.data.current_weather.windspeed} km/h")
                }

                // Test Route Weather (e.g., Route ID = 4 for Via Selo)
                val routeWeather = routeRepository.getRouteWeather(4)
                android.util.Log.d("API_TEST", "Route Weather: ${routeWeather.route_name}, Basecamp Alt: ${routeWeather.basecamp_altitude} mdpl")
                if (routeWeather.data != null) {
                    android.util.Log.d("API_TEST", "Basecamp Current Temp: ${routeWeather.data.current_weather.temperature}°C, Wind: ${routeWeather.data.current_weather.windspeed} km/h")
                }

                _testState.value = UiState.Success("Weather APIs tested successfully! Check Logcat API_TEST.")
            } catch (e: Exception) {
                android.util.Log.e("API_TEST", "Error testing Weather API: ${e.message}", e)
                _testState.value = UiState.Error("Weather Test failed: ${e.message}")
            }
        }
    }

    fun login(request: LoginRequest) {
        viewModelScope.launch {
            _loginState.value = UiState.Loading
            try {
                val response = authRepository.login(request)
                // On success -> token is saved in repository via DataStore
                _loginState.value = UiState.Success(response)
            } catch (e: HttpException) {
                if (e.code() == 401) {
                    _loginState.value = UiState.Error("Email atau password salah.")
                } else {
                    _loginState.value = UiState.Error("Terjadi kesalahan dari server: ${e.code()}")
                }
            } catch (e: IOException) {
                _loginState.value = UiState.Error("Tidak ada koneksi internet")
            } catch (e: Exception) {
                _loginState.value = UiState.Error("Terjadi kesalahan: ${e.message}")
            }
        }
    }

    fun testEndpoints() {
        viewModelScope.launch {
            _testState.value = UiState.Loading
            try {
                // 1. GET /api/mountains
                val mountains = mountainRepository.getMountains()
                android.util.Log.d("API_TEST", "Mountains count: ${mountains.size}, First: ${mountains.firstOrNull()?.name}")

                // 2. GET /api/user
                val user = authRepository.getUserProfile()
                android.util.Log.d("API_TEST", "User profile: ID=${user.id}, Name=${user.name}, Email=${user.email}")

                // 3. GET /api/transactions
                val transactions = transactionRepository.getTransactions()
                android.util.Log.d("API_TEST", "Transactions count: ${transactions.data.size}")
                if (transactions.data.isNotEmpty()) {
                    val firstTx = transactions.data.first()
                    android.util.Log.d("API_TEST", "First Tx: ID=${firstTx.id}, Status=${firstTx.status}, GrossAmount=${firstTx.grossAmount}")
                }

                _testState.value = UiState.Success("All endpoints tested successfully! Check Logcat API_TEST.")
            } catch (e: Exception) {
                android.util.Log.e("API_TEST", "Error testing API: ${e.message}", e)
                _testState.value = UiState.Error("Test failed: ${e.message}")
            }
        }
    }
}
