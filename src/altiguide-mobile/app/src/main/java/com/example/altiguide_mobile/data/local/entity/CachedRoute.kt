package com.example.altiguide_mobile.data.local.entity

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "cached_routes")
data class CachedRoute(
    @PrimaryKey val id: Int,
    val name: String,
    val difficulty: String?,
    val distanceKm: Double?,
    val durationHours: Double?,
    val latitude: Double?,
    val longitude: Double?,
    val cachedAt: Long = System.currentTimeMillis()
)

