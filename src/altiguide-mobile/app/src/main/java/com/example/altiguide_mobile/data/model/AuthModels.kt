package com.example.altiguide_mobile.data.model

data class AuthResponse(
    val message: String,
    val user: UserModel?,
    val token: String?
)

data class LoginRequest(
    val email: String,
    val password: String
)

data class RegisterRequest(
    val name: String,
    val email: String,
    val password: String,
    val password_confirmation: String,
    val phone_number: String?,
    val age: Int?,
    val address: String?,
    val emergency_contact: String?,
    val nik: String
)

data class UserModel(
    val id: String,
    val name: String,
    val email: String,
    val phone_number: String?,
    val age: Int?,
    val address: String?,
    val emergency_contact: String?,
    val nik: String?
)

