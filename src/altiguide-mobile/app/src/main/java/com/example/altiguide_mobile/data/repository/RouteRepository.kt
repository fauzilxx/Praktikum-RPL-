package com.example.altiguide_mobile.data.repository

import com.example.altiguide_mobile.data.local.dao.RouteDao
import com.example.altiguide_mobile.data.local.dao.WaypointDao
import com.example.altiguide_mobile.data.local.entity.CachedRoute
import com.example.altiguide_mobile.data.local.entity.CachedWaypoint
import com.example.altiguide_mobile.data.model.RouteModel
import com.example.altiguide_mobile.data.network.AltiGuideApiService
import kotlinx.coroutines.flow.Flow
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class RouteRepository @Inject constructor(
    private val apiService: AltiGuideApiService,
    private val routeDao: RouteDao,
    private val waypointDao: WaypointDao
) {
    suspend fun getRoutes(): List<RouteModel> {
        return apiService.getRoutes()
    }

    suspend fun getRouteDetail(id: Int, syncToLocal: Boolean = false): RouteModel {
        val route = apiService.getRouteDetail(id)
        if (syncToLocal) {
            // Cache the route
            routeDao.insertRoute(
                CachedRoute(
                    id = route.id,
                    name = route.name,
                    difficulty = route.difficulty,
                    distanceKm = route.distance_km,
                    durationHours = route.duration_hours,
                    latitude = route.latitude,
                    longitude = route.longitude
                )
            )
            
            // Cache its waypoints
            route.waypoints?.let { waypoints ->
                waypointDao.deleteWaypointsForRoute(route.id)
                waypointDao.insertWaypoints(waypoints.map {
                    CachedWaypoint(
                        id = it.id,
                        routeId = it.route_id,
                        name = it.name,
                        altitude = it.altitude,
                        orderIndex = it.order_index,
                        distanceFromPrev = it.distance_from_prev,
                        estimatedTimeMinutes = it.estimated_time_minutes,
                        description = it.description,
                        hasWaterSource = it.has_water_source
                    )
                })
            }
        }
        return route
    }

    suspend fun getRouteWeather(id: Int): com.example.altiguide_mobile.data.model.WeatherResponse {
        return apiService.getRouteWeather(id)
    }

    // Offline support flows
    fun getCachedRoute(id: Int): Flow<CachedRoute?> = routeDao.getRoute(id)
    fun getCachedWaypoints(routeId: Int): Flow<List<CachedWaypoint>> = waypointDao.getWaypointsForRoute(routeId)
}
