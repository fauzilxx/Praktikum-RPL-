package com.example.altiguide_mobile.data.model

import com.google.gson.JsonElement
import com.google.gson.annotations.SerializedName

data class MountainModel(
    val id: Int,
    val name: String,
    val description: String?,
    val altitude: Int?,
    val latitude: Double?,
    val longitude: Double?,
    val province: String?,
    val image_url: String?,
    val routes: List<RouteModel>?
)

data class RouteModel(
    val id: Int,
    val mountain_id: Int,
    val name: String,
    val difficulty: String?,
    val distance_km: Double?,
    val duration_hours: Double?,
    val daily_quota: Int?,
    val latitude: Double?,
    val longitude: Double?,
    val mountain: MountainModel?,
    val route_info: RouteInfoModel?,
    val waypoints: List<WaypointModel>?,
    @SerializedName("track_coordinates")
    val trackCoordinates: JsonElement? = null
)

data class RouteInfoModel(
    val id: Int,
    val route_id: Int,
    val basecamp_name: String?,
    val basecamp_altitude: Int?,
    val simaksi_price: Int?,
    val facilities: String?,
    val contact_person: String?,
    val notes: String?,
    val ojek_price: Int?,
    val ojek_description: String?
)

data class WaypointModel(
    val id: Int,
    val route_id: Int,
    val name: String,
    val altitude: Int?,
    val order_index: Int,
    val distance_from_prev: Double?,
    val estimated_time_minutes: Int?,
    val description: String?,
    val has_water_source: Boolean
)

data class WeatherResponse(
    val status: String,
    val mountain_name: String?,
    val route_name: String?,
    val basecamp_altitude: Int?,
    val data: WeatherData?
)

data class WeatherData(
    val current_weather: CurrentWeather,
    val daily: DailyWeather
)

data class CurrentWeather(
    val temperature: Double,
    val windspeed: Double,
    val weathercode: Int
)

data class DailyWeather(
    val temperature_2m_max: List<Double>,
    val temperature_2m_min: List<Double>,
    val weathercode: List<Int>
)
