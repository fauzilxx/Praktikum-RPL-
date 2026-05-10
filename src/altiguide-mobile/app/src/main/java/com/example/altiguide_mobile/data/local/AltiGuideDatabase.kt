package com.example.altiguide_mobile.data.local

import androidx.room.Database
import androidx.room.RoomDatabase
import com.example.altiguide_mobile.data.local.dao.RouteDao
import com.example.altiguide_mobile.data.local.dao.WaypointDao
import com.example.altiguide_mobile.data.local.entity.CachedRoute
import com.example.altiguide_mobile.data.local.entity.CachedWaypoint

@Database(entities = [CachedRoute::class, CachedWaypoint::class], version = 1, exportSchema = true)
abstract class AltiGuideDatabase : RoomDatabase() {
    abstract fun routeDao(): RouteDao
    abstract fun waypointDao(): WaypointDao
}

