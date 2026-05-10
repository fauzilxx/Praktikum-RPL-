package com.example.altiguide_mobile.data.network

import com.example.altiguide_mobile.data.model.AuthResponse
import com.example.altiguide_mobile.data.model.LoginRequest
import com.example.altiguide_mobile.data.model.RegisterRequest
import com.example.altiguide_mobile.data.model.UserModel
import com.example.altiguide_mobile.data.model.MountainModel
import com.example.altiguide_mobile.data.model.RouteModel
import com.example.altiguide_mobile.data.model.WeatherResponse
import com.example.altiguide_mobile.data.model.TransactionListResponse
import com.example.altiguide_mobile.data.model.TransactionDetailResponse
import com.example.altiguide_mobile.data.model.HikingSessionModel
import okhttp3.ResponseBody
import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.PUT
import retrofit2.http.Path

interface AltiGuideApiService {

    @POST("register")
    suspend fun register(@Body request: RegisterRequest): AuthResponse
    
    @POST("login")
    suspend fun login(@Body request: LoginRequest): AuthResponse

    @POST("logout")
    suspend fun logout() // response structure depends on use cases but usually just 200 OK

    @GET("user")
    suspend fun getUserProfile(): UserModel

    @PUT("user/profile")
    suspend fun updateUserProfile(@Body request: Map<String, Any>): Response<AuthResponse>

    @PUT("user/password")
    suspend fun changePassword(@Body request: Map<String, String>): Response<AuthResponse>
    
    // Mountains
    @GET("mountains")
    suspend fun getMountains(): List<MountainModel>
    
    @GET("mountains/{id}")
    suspend fun getMountainDetail(@Path("id") id: Int): MountainModel
    
    @GET("mountains/{id}/weather")
    suspend fun getMountainWeather(@Path("id") id: Int): WeatherResponse

    // Routes
    @GET("routes")
    suspend fun getRoutes(): List<RouteModel>
    
    @GET("routes/{id}")
    suspend fun getRouteDetail(@Path("id") id: Int): RouteModel
    
    @GET("routes/{id}/weather")
    suspend fun getRouteWeather(@Path("id") id: Int): WeatherResponse

    // Transactions
    @GET("transactions")
    suspend fun getTransactions(): TransactionListResponse
    
    @GET("transactions/{id}")
    suspend fun getTransactionDetail(@Path("id") id: String): TransactionDetailResponse
    
    @GET("transactions/{id}/pdf")
    suspend fun downloadETicketPdf(@Path("id") id: String): ResponseBody

    // Hiking Sessions
    @GET("hiking-sessions")
    suspend fun getHikingSessions(): List<HikingSessionModel>
    
    @GET("hiking-sessions/{id}")
    suspend fun getHikingSessionDetail(@Path("id") id: String): HikingSessionModel

    // Additional Features
    @POST("validate-nik")
    suspend fun validateNik(@Body request: Map<String, String>): Response<Any>

    @POST("forgot-password/send-code")
    suspend fun sendForgotPasswordCode(@Body request: Map<String, String>): Response<Any>

    @POST("forgot-password/verify-code")
    suspend fun verifyForgotPasswordCode(@Body request: Map<String, String>): Response<Any>

    @POST("forgot-password/reset")
    suspend fun resetPassword(@Body request: Map<String, String>): Response<Any>
}
