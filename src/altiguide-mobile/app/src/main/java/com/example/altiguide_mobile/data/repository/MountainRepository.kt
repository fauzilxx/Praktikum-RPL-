package com.example.altiguide_mobile.data.repository

import com.example.altiguide_mobile.data.model.MountainModel
import com.example.altiguide_mobile.data.model.WeatherResponse
import com.example.altiguide_mobile.data.network.AltiGuideApiService
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class MountainRepository @Inject constructor(
    private val apiService: AltiGuideApiService
) {
    suspend fun getMountains(): List<MountainModel> {
        return apiService.getMountains()
    }

    suspend fun getMountainDetail(id: Int): MountainModel {
        return apiService.getMountainDetail(id)
    }

    suspend fun getMountainWeather(id: Int): WeatherResponse {
        return apiService.getMountainWeather(id)
    }
}

