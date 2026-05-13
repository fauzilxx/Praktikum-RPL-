package com.example.altiguide_mobile.di

import android.content.Context
import com.example.altiguide_mobile.data.network.AltiGuideApiService
import com.example.altiguide_mobile.data.local.AltiGuideDatabase
import com.example.altiguide_mobile.data.local.dao.RouteDao
import com.example.altiguide_mobile.data.local.dao.WaypointDao
import com.example.altiguide_mobile.util.AuthDataStore
import androidx.room.Room
import com.google.gson.GsonBuilder
import dagger.Module
import dagger.Provides
import dagger.hilt.InstallIn
import dagger.hilt.android.qualifiers.ApplicationContext
import dagger.hilt.components.SingletonComponent
import okhttp3.Interceptor
import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import javax.inject.Singleton
import kotlinx.coroutines.flow.first
import kotlinx.coroutines.runBlocking

@Module
@InstallIn(SingletonComponent::class)
object AppModule {

    private const val BASE_URL = "http://10.0.2.2:8000/api/" // Android Emulator localhost

    @Provides
    @Singleton
    fun provideAuthDataStore(@ApplicationContext context: Context): AuthDataStore {
        return AuthDataStore(context)
    }

    @Provides
    @Singleton
    fun provideOkHttpClient(authDataStore: AuthDataStore): OkHttpClient {
        val loggingInterceptor = HttpLoggingInterceptor().apply {
            level = HttpLoggingInterceptor.Level.BODY
        }

        val authInterceptor = Interceptor { chain ->
            val token = runBlocking { authDataStore.authTokenFlow.first() }
            val requestBuilder = chain.request().newBuilder()
            
            requestBuilder.addHeader("Accept", "application/json")
            requestBuilder.addHeader("Content-Type", "application/json")
            
            if (token.isNotEmpty()) {
                requestBuilder.addHeader("Authorization", "Bearer $token")
            }
            
            chain.proceed(requestBuilder.build())
        }

        return OkHttpClient.Builder()
            .addInterceptor(loggingInterceptor)
            .addInterceptor(authInterceptor)
            .readTimeout(60, java.util.concurrent.TimeUnit.SECONDS)
            .connectTimeout(30, java.util.concurrent.TimeUnit.SECONDS)
            .writeTimeout(30, java.util.concurrent.TimeUnit.SECONDS)
            .build()
    }

    @Provides
    @Singleton
    fun provideRetrofit(okHttpClient: OkHttpClient): Retrofit {
        val gson = GsonBuilder()
            .setLenient()
            .serializeNulls()
            .create()

        return Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(okHttpClient)
            .addConverterFactory(GsonConverterFactory.create(gson))
            .build()
    }

    @Provides
    @Singleton
    fun provideApiService(retrofit: Retrofit): AltiGuideApiService {
        return retrofit.create(AltiGuideApiService::class.java)
    }

    @Provides
    @Singleton
    fun provideDatabase(@ApplicationContext context: Context): AltiGuideDatabase {
        return Room.databaseBuilder(
            context,
            AltiGuideDatabase::class.java,
            "altiguide_database"
        ).build()
    }

    @Provides
    @Singleton
    fun provideRouteDao(database: AltiGuideDatabase): RouteDao {
        return database.routeDao()
    }

    @Provides
    @Singleton
    fun provideWaypointDao(database: AltiGuideDatabase): WaypointDao {
        return database.waypointDao()
    }
}
