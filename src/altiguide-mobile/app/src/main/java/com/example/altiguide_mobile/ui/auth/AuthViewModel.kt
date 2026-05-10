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
    private val transactionRepository: TransactionRepository
) : ViewModel() {

    private val _loginState = MutableStateFlow<UiState<AuthResponse>>(UiState.Idle)
    val loginState: StateFlow<UiState<AuthResponse>> = _loginState.asStateFlow()

    private val _testState = MutableStateFlow<UiState<String>>(UiState.Idle)
    val testState: StateFlow<UiState<String>> = _testState.asStateFlow()

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
