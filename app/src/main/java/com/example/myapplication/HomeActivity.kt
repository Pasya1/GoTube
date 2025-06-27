package com.example.myapplication

import android.content.Intent
import android.os.Bundle
import android.view.MenuItem
import android.view.View
import android.widget.ImageButton
import android.widget.PopupMenu
import android.widget.TextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.firestore.FirebaseFirestore

class HomeActivity : AppCompatActivity() {

    private lateinit var deliveryList: MutableList<DeliveryHistory>
    private lateinit var recyclerView: RecyclerView
    private lateinit var adapter: DeliveryAdapter

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
        setContentView(R.layout.activity_home)

        val currentUser = FirebaseAuth.getInstance().currentUser
        val email = currentUser?.email ?: "user@example.com"
        val username = email.substringBefore("@")

        val tvWelcome: TextView = findViewById(R.id.tvWelcome)
        tvWelcome.text = "Selamat datang, $username!"

        val btnDelivery: ImageButton = findViewById(R.id.btnDelivery)
        val btnHistory: ImageButton = findViewById(R.id.btnHistory)
        val btnProfile: ImageButton = findViewById(R.id.btnProfile)
        val btnNitro: ImageButton = findViewById(R.id.btnNitro)
        val btnOutlet: ImageButton = findViewById(R.id.btnOutlet)
        val lihatDetail: TextView = findViewById(R.id.lihatdetail)
        val btnUserProfile: ImageButton = findViewById(R.id.btnUserProfile)

        // Setup RecyclerView
        deliveryList = mutableListOf()
        recyclerView = findViewById(R.id.recyclerViewHistory)
        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = DeliveryAdapter(deliveryList)
        recyclerView.adapter = adapter

        // Load data saat pertama dibuka
        refreshDeliveryData()

        // Navigasi antar halaman
        btnDelivery.setOnClickListener {
            val intent = Intent(this, DeliveryActivity::class.java)
            startActivityForResult(intent, 100) // supaya bisa refresh
        }

        btnHistory.setOnClickListener {
            startActivity(Intent(this, HistoryActivity::class.java))
        }

        btnProfile.setOnClickListener {
            startActivity(Intent(this, ProfileActivity::class.java))
        }

        btnNitro.setOnClickListener {
            startActivity(Intent(this, DataTabungActivity::class.java))
        }

        btnOutlet.setOnClickListener {
            startActivity(Intent(this, OutletActivity::class.java))
        }

        lihatDetail.setOnClickListener {
            startActivity(Intent(this, HistoryActivity::class.java))
        }

        btnUserProfile.setOnClickListener { view ->
            showPopupMenu(view)
        }
    }

    // Refresh otomatis setelah kembali dari DeliveryActivity
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == 100 && resultCode == RESULT_OK) {
            refreshDeliveryData()
        }
    }

    // Fungsi ambil ulang data 3 pengiriman terbaru
    private fun refreshDeliveryData() {
        val db = FirebaseFirestore.getInstance()
        db.collection("delivery")
            .orderBy("tanggal", com.google.firebase.firestore.Query.Direction.DESCENDING)
            .limit(3)
            .get()
            .addOnSuccessListener { result ->
                deliveryList.clear()
                for (document in result) {
                    val outlet = document.getString("outlet") ?: "-"
                    val tanggal = document.getString("tanggal") ?: "-"
                    val kodeTabung = document.getString("kodeTabung") ?: "-"
                    val namaPengiriman = document.getString("namaPengiriman") ?: "-"
                    val statusTabung = document.getString("statusTabung") ?: "-"
                    val status = document.getString("status") ?: "Pending"

                    deliveryList.add(
                        DeliveryHistory(outlet, tanggal, kodeTabung, namaPengiriman, statusTabung, status)
                    )
                }
                adapter.notifyDataSetChanged()
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Gagal ambil data: ${e.message}", Toast.LENGTH_SHORT).show()
            }
    }

    // Menu popup profil
    private fun showPopupMenu(view: View) {
        val popup = PopupMenu(this, view)
        popup.menuInflater.inflate(R.menu.profile_menu, popup.menu)

        popup.setOnMenuItemClickListener { item: MenuItem ->
            when (item.itemId) {
                R.id.menu_logout -> {
                    Toast.makeText(this, "Logout berhasil", Toast.LENGTH_SHORT).show()
                    val intent = Intent(this, MainActivity::class.java)
                    startActivity(intent)
                    finish()
                    true
                }
                else -> false
            }
        }
        popup.show()
    }
}
