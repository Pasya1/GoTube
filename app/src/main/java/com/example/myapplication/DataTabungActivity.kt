package com.example.myapplication

import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.firestore.FirebaseFirestore

class DataTabungActivity : AppCompatActivity() {

    private lateinit var etNoTabung: EditText
    private lateinit var etSeriTabung: EditText
    private lateinit var btnTambah: Button
    private lateinit var recyclerView: RecyclerView
    private lateinit var adapter: TabungAdapter
    private val tabungList = mutableListOf<TabungModel>()
    private lateinit var btnBack: ImageButton
    private lateinit var searchView: SearchView
    private lateinit var db: FirebaseFirestore

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
        setContentView(R.layout.activity_data_tabung)

        etNoTabung = findViewById(R.id.etNoTabung)
        etSeriTabung = findViewById(R.id.etSeriTabung)
        btnTambah = findViewById(R.id.btnTambah)
        recyclerView = findViewById(R.id.recyclerViewTabung)
        btnBack = findViewById(R.id.btnBack)
        searchView = findViewById(R.id.searchView)
        db = FirebaseFirestore.getInstance()

        recyclerView.layoutManager = LinearLayoutManager(this)
        adapter = TabungAdapter(tabungList)
        recyclerView.adapter = adapter

        loadData()

        btnBack.setOnClickListener {
            finish()
        }

        btnTambah.setOnClickListener {
            val noTabung = etNoTabung.text.toString().trim()
            val seriTabung = etSeriTabung.text.toString().trim()

            if (noTabung.isEmpty() || seriTabung.isEmpty()) {
                Toast.makeText(this, "Harap isi semua data", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            val exists = tabungList.any { it.noTabung.equals(noTabung, ignoreCase = true) }
            if (exists) {
                Toast.makeText(this, "Kode tabung sudah ada!", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            val newTabung = hashMapOf(
                "noTabung" to noTabung,
                "seriTabung" to seriTabung
            )

            db.collection("tabung")
                .add(newTabung)
                .addOnSuccessListener {
                    Toast.makeText(this, "Data berhasil ditambahkan", Toast.LENGTH_SHORT).show()
                    etNoTabung.text.clear()
                    etSeriTabung.text.clear()
                    loadData()
                }
                .addOnFailureListener { e ->
                    Toast.makeText(this, "Gagal menyimpan data: ${e.message}", Toast.LENGTH_LONG).show()
                }
        }

        searchView.setOnQueryTextListener(object : SearchView.OnQueryTextListener {
            override fun onQueryTextSubmit(query: String?): Boolean {
                query?.let { adapter.filterList(it) }
                return true
            }

            override fun onQueryTextChange(newText: String?): Boolean {
                newText?.let { adapter.filterList(it) }
                return true
            }
        })
    }

    private fun loadData() {
        db.collection("tabung")
            .get()
            .addOnSuccessListener { result ->
                tabungList.clear()
                for (document in result) {
                    val noTabung = document.getString("noTabung") ?: ""
                    val seriTabung = document.getString("seriTabung") ?: ""
                    val tabung = TabungModel(noTabung, seriTabung, document.id)
                    tabungList.add(tabung)
                }
                adapter.setTabungList(tabungList)
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Gagal memuat data: ${e.message}", Toast.LENGTH_LONG).show()
            }
    }
}
