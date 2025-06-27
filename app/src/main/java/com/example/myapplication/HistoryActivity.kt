package com.example.myapplication

import android.os.Bundle
import android.widget.ImageButton
import android.widget.SearchView
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.firestore.FirebaseFirestore
import com.google.firebase.auth.FirebaseAuth
import android.widget.Toast

class HistoryActivity : AppCompatActivity() {

    private lateinit var recyclerView: RecyclerView
    private lateinit var riwayatAdapter: RiwayatAdapter
    private lateinit var searchView2: SearchView
    private val riwayatList = mutableListOf<RiwayatModel>()
    private lateinit var btnBack: ImageButton

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
        setContentView(R.layout.activity_history)

        // Inisialisasi view terlebih dahulu
        recyclerView = findViewById(R.id.recyclerViewRiwayat)
        searchView2 = findViewById(R.id.searchView2)
        btnBack = findViewById(R.id.btnBack)

        // Layout Manager dan Adapter
        recyclerView.layoutManager = LinearLayoutManager(this)
        val userEmail = FirebaseAuth.getInstance().currentUser?.email ?: ""
        riwayatAdapter = RiwayatAdapter(riwayatList, userEmail)
        recyclerView.adapter = riwayatAdapter

        // Tombol kembali
        btnBack.setOnClickListener {
            finish()
        }

        // Ambil data dari Firebase
        val db = FirebaseFirestore.getInstance()
        db.collection("delivery")
            .orderBy("tanggal", com.google.firebase.firestore.Query.Direction.DESCENDING)
            .get()
            .addOnSuccessListener { result ->
                riwayatList.clear()
                for (document in result) {
                    val outlet = document.getString("outlet") ?: "-"
                    val kodeTabung = document.getString("kodeTabung") ?: "-"
                    val tanggal = document.getString("tanggal") ?: "-"
                    val status = document.getString("status") ?: "Pending"
                    val namaPengiriman = document.getString("namaPengiriman") ?: "-"
                    val statusTabung = document.getString("statusTabung") ?: "-"
                    val documentId = document.id

                    riwayatList.add(
                        RiwayatModel(
                            outlet = outlet,
                            kodeTabung = kodeTabung,
                            tanggal = tanggal,
                            status = status,
                            namaPengiriman = namaPengiriman,
                            statusTabung = statusTabung,
                            documentId = documentId
                        )
                    )
                }
                riwayatAdapter.updateData(riwayatList)
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Gagal ambil data: ${e.message}", Toast.LENGTH_SHORT).show()
            }

        // Fitur pencarian
        searchView2.setOnQueryTextListener(object : SearchView.OnQueryTextListener {
            override fun onQueryTextSubmit(query: String?): Boolean {
                query?.let { riwayatAdapter.filter(it) }
                return true
            }

            override fun onQueryTextChange(newText: String?): Boolean {
                newText?.let { riwayatAdapter.filter(it) }
                return true
            }
        })
    }



}
