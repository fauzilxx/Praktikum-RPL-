package com.example.altiguide_mobile.data.model

import com.google.gson.annotations.SerializedName

data class TransactionListResponse(
    val status: String,
    val data: List<TransactionModel>
)

data class TransactionDetailResponse(
    val status: String,
    val data: TransactionModel
)

data class TransactionModel(
    val id: String,
    @SerializedName("order_id")
    val orderId: String,
    @SerializedName("gross_amount")
    val grossAmount: Int,
    val status: String,
    @SerializedName("payment_type")
    val paymentType: String?,
    @SerializedName("qr_url")
    val qrUrl: String?,
    @SerializedName("expiry_time")
    val expiryTime: String?,
    @SerializedName("created_at")
    val createdAt: String?,
    @SerializedName("hiking_session")
    val hikingSession: HikingSessionModel?
)
