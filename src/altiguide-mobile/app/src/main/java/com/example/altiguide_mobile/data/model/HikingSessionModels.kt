package com.example.altiguide_mobile.data.model

data class HikingSessionModel(
    val id: String,
    val leader_id: String,
    val route_id: Int,
    val transaction_id: String,
    val group_name: String,
    val start_date: String?,
    val end_date: String?,
    val hike_type: String?,
    val status: String,
    val route: RouteModel?,
    val members: List<HikingMemberModel>?,
    val transaction: TransactionModel?
)

data class HikingMemberModel(
    val id: String,
    val hiking_session_id: String,
    val user_id: String?,
    val identity_number: String,
    val full_name: String,
    val phone_number: String,
    val emergency_contact: String
)

