package com.example.altiguide_mobile.data.repository

import com.example.altiguide_mobile.data.model.AuthResponse
import com.example.altiguide_mobile.data.model.LoginRequest
import com.example.altiguide_mobile.data.model.RegisterRequest
import com.example.altiguide_mobile.data.model.UserModel
import com.example.altiguide_mobile.data.network.AltiGuideApiService
import com.example.altiguide_mobile.util.AuthDataStore
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class AuthRepository @Inject constructor(
    private val apiService: AltiGuideApiService,
    private val authDataStore: AuthDataStore
) {
    suspend fun login(request: LoginRequest): AuthResponse {
        val response = apiService.login(request)
        response.token?.let {
            authDataStore.saveToken(it)
        }
        return response
    }

    suspend fun register(request: RegisterRequest): AuthResponse {
        val response = apiService.register(request)
        response.token?.let {
            authDataStore.saveToken(it)
        }
        return response
    }

    suspend fun logout() {
        try {
            apiService.logout()
        } finally {
            // Selalu hapus token lokal meskipun api gagal
            authDataStore.clearToken()
        }
    }

    suspend fun getUserProfile(): UserModel {
        return apiService.getUserProfile()
    }
}

