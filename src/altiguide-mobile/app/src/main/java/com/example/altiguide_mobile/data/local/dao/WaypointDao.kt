package com.example.altiguide_mobile.data.local.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import com.example.altiguide_mobile.data.local.entity.CachedWaypoint
import kotlinx.coroutines.flow.Flow

@Dao
interface WaypointDao {
    @Query("SELECT * FROM cached_waypoints WHERE routeId = :routeId ORDER BY orderIndex ASC")
    fun getWaypointsForRoute(routeId: Int): Flow<List<CachedWaypoint>>

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertWaypoints(waypoints: List<CachedWaypoint>)

    @Query("DELETE FROM cached_waypoints WHERE routeId = :routeId")
    suspend fun deleteWaypointsForRoute(routeId: Int)
}

