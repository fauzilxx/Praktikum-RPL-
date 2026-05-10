package com.example.altiguide_mobile.ui.auth

import android.util.Log
import androidx.compose.foundation.layout.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.unit.dp
import androidx.hilt.navigation.compose.hiltViewModel
import com.example.altiguide_mobile.data.model.LoginRequest
import com.example.altiguide_mobile.util.UiState

@Composable
fun LoginScreen(
    viewModel: AuthViewModel = hiltViewModel()
) {
    val loginState by viewModel.loginState.collectAsState()
    val testState by viewModel.testState.collectAsState()

    var email by remember { mutableStateOf("test@example.com") }
    var password by remember { mutableStateOf("password123") }

    Column(
        modifier = Modifier
            .fillMaxSize()
            .padding(16.dp),
        verticalArrangement = Arrangement.Center,
        horizontalAlignment = Alignment.CenterHorizontally
    ) {
        // Debug Text
        Text(
            text = "DEBUG - BASE_URL: http://10.0.2.2:8000/api/",
            color = Color.Gray,
            modifier = Modifier.padding(bottom = 32.dp)
        )

        OutlinedTextField(
            value = email,
            onValueChange = { email = it },
            label = { Text("Email") },
            modifier = Modifier.fillMaxWidth()
        )

        Spacer(modifier = Modifier.height(8.dp))

        OutlinedTextField(
            value = password,
            onValueChange = { password = it },
            label = { Text("Password") },
            visualTransformation = PasswordVisualTransformation(),
            modifier = Modifier.fillMaxWidth()
        )

        Spacer(modifier = Modifier.height(16.dp))

        Button(
            onClick = {
                viewModel.login(LoginRequest(email, password))
            },
            modifier = Modifier.fillMaxWidth(),
            enabled = loginState !is UiState.Loading
        ) {
            Text("Login API Test")
        }

        Spacer(modifier = Modifier.height(16.dp))

        Button(
            onClick = {
                viewModel.testEndpoints()
            },
            modifier = Modifier.fillMaxWidth(),
            enabled = testState !is UiState.Loading
        ) {
            Text("Test Authorized Endpoints")
        }

        Spacer(modifier = Modifier.height(32.dp))

        // Observe UiState
        when (val state = loginState) {
            is UiState.Idle -> { }
            is UiState.Loading -> {
                CircularProgressIndicator()
            }
            is UiState.Success -> {
                Log.d("API_TEST", "Login sukses! Token: ${state.data.token}")
                Text(
                    text = "Login Sukses! Cek Logcat (API_TEST)",
                    color = Color.Green
                )
            }
            is UiState.Error -> {
                Text(
                    text = "Login Error: " + state.message,
                    color = Color.Red
                )
            }
        }

        Spacer(modifier = Modifier.height(16.dp))

        when (val state = testState) {
            is UiState.Idle -> { }
            is UiState.Loading -> {
                CircularProgressIndicator()
            }
            is UiState.Success -> {
                Text(
                    text = state.data,
                    color = Color.Green
                )
            }
            is UiState.Error -> {
                Text(
                    text = state.message,
                    color = Color.Red
                )
            }
        }
    }
}
