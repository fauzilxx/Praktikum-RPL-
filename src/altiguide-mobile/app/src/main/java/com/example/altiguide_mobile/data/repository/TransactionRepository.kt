package com.example.altiguide_mobile.data.repository

import com.example.altiguide_mobile.data.model.HikingSessionModel
import com.example.altiguide_mobile.data.model.TransactionDetailResponse
import com.example.altiguide_mobile.data.model.TransactionListResponse
import com.example.altiguide_mobile.data.network.AltiGuideApiService
import okhttp3.ResponseBody
import javax.inject.Inject
import javax.inject.Singleton

@Singleton
class TransactionRepository @Inject constructor(
    private val apiService: AltiGuideApiService
) {
    suspend fun getTransactions(): TransactionListResponse {
        return apiService.getTransactions()
    }

    suspend fun getTransactionDetail(id: String): TransactionDetailResponse {
        return apiService.getTransactionDetail(id)
    }

    suspend fun downloadETicketPdf(id: String): ResponseBody {
        return apiService.downloadETicketPdf(id)
    }

    suspend fun getHikingSessions(): List<HikingSessionModel> {
        return apiService.getHikingSessions()
    }

    suspend fun getHikingSessionDetail(id: String): HikingSessionModel {
        return apiService.getHikingSessionDetail(id)
    }
}

