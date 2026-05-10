package com.example.altiguide_mobile.data.local.dao

import androidx.room.Dao
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import com.example.altiguide_mobile.data.local.entity.CachedRoute
import kotlinx.coroutines.flow.Flow

@Dao
interface RouteDao {
    @Query("SELECT * FROM cached_routes WHERE id = :routeId LIMIT 1")
    fun getRoute(routeId: Int): Flow<CachedRoute?>

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertRoute(route: CachedRoute)

    @Query("DELETE FROM cached_routes WHERE id = :routeId")
    suspend fun deleteRoute(routeId: Int)
}

