package com.example.altiguide_mobile.data.local.entity

import androidx.room.Entity
import androidx.room.PrimaryKey

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

