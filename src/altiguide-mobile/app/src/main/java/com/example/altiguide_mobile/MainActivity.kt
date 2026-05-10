package com.example.altiguide_mobile

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.compose.setContent
import androidx.activity.enableEdgeToEdge
import androidx.compose.foundation.layout.Box
import androidx.compose.foundation.layout.fillMaxSize
import androidx.compose.foundation.layout.padding
import androidx.compose.material3.Scaffold
import androidx.compose.runtime.Composable
import androidx.compose.ui.Modifier
import androidx.compose.ui.tooling.preview.Preview
import dagger.hilt.android.AndroidEntryPoint
import com.example.altiguide_mobile.ui.theme.AltiguidemobileTheme
import com.example.altiguide_mobile.ui.auth.LoginScreen

@AndroidEntryPoint
class MainActivity : ComponentActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContent {
            AltiguidemobileTheme {
                Scaffold(modifier = Modifier.fillMaxSize()) { innerPadding ->
                    // Set LoginScreen to test the API directly
                    Box(modifier = Modifier.padding(innerPadding)) {
                        LoginScreen()
                    }
                }
            }
        }
    }
}