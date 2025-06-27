package com.example.myapplication

import android.app.AlertDialog
import android.os.Bundle
import android.view.LayoutInflater
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.firestore.FirebaseFirestore
import android.widget.Toast
import android.content.Intent
import android.view.View
import com.google.firebase.auth.FirebaseAuth



class OutletActivity : AppCompatActivity() {

    private lateinit var recyclerView: RecyclerView
    private lateinit var outletAdapter: OutletAdapter
    private val outletList = mutableListOf<OutletModel>()
    private lateinit var btnBack: ImageButton
    private lateinit var db: FirebaseFirestore
    private var selectedLatitude = 0.0
    private var selectedLongitude = 0.0
    private lateinit var auth: FirebaseAuth
    private var isAdmin = false



    override fun onCreate(savedInstanceState: Bundle?) {
        db = FirebaseFirestore.getInstance()
        super.onCreate(savedInstanceState)
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
        setContentView(R.layout.activity_outlet)

        auth = FirebaseAuth.getInstance()
        val currentUser = auth.currentUser
        isAdmin = currentUser?.email == "admin@gmail.com"


        recyclerView = findViewById(R.id.recyclerView)
        recyclerView.layoutManager = LinearLayoutManager(this)
        outletAdapter = OutletAdapter(outletList, isAdmin)
        recyclerView.adapter = outletAdapter
        db.collection("outlet")
            .get()
            .addOnSuccessListener { result ->
                for (document in result) {
                    val outlet = document.toObject(OutletModel::class.java)
                    outletList.add(outlet)
                }
                outletAdapter.notifyDataSetChanged()
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Gagal ambil data: ${e.message}", Toast.LENGTH_SHORT).show()
            }

        btnBack = findViewById(R.id.btnBack)

        val btnTambah: Button = findViewById(R.id.btnTambah)
        btnTambah.setOnClickListener {
            showTambahOutletDialog()
        }

        if (!isAdmin) {
            btnTambah.visibility = View.GONE
        }

        btnBack.setOnClickListener {
            finish() // Kembali ke HomeActivity tanpa membuat instance baru
        }

    }
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == 1001 && resultCode == RESULT_OK) {
            selectedLatitude = data?.getDoubleExtra("latitude", 0.0) ?: 0.0
            selectedLongitude = data?.getDoubleExtra("longitude", 0.0) ?: 0.0
            Toast.makeText(this, "Lokasi Dipilih!", Toast.LENGTH_SHORT).show()
        }
    }

    private fun showTambahOutletDialog(isEditMode: Boolean = false) {

        val dialogView = LayoutInflater.from(this).inflate(R.layout.dialog_tambah_outlet, null)
        val btnPilihLokasi = dialogView.findViewById<Button>(R.id.btnPilihLokasi)
        btnPilihLokasi.setOnClickListener {
            val intent = Intent(this, PickLocationActivity::class.java)
            startActivityForResult(intent, 1001)
        }
        val etNamaOutlet = dialogView.findViewById<EditText>(R.id.etNamaOutlet)
        val etNamaSPV = dialogView.findViewById<EditText>(R.id.etNamaSPV)
        val etNamaArea = dialogView.findViewById<EditText>(R.id.etNamaArea)
        val etMerkInflator = dialogView.findViewById<EditText>(R.id.etMerkInflator)
        val etMerkRegulator = dialogView.findViewById<EditText>(R.id.etMerkRegulator)
        val etDistribusi = dialogView.findViewById<EditText>(R.id.etDistribusi)
        val etNamaVendor = dialogView.findViewById<EditText>(R.id.etNamaVendor)
        val etHargaIsiN2 = dialogView.findViewById<EditText>(R.id.etHargaIsiN2)
        val btnSimpan = dialogView.findViewById<Button>(R.id.btnSimpan)

        if (isEditMode) {
            btnSimpan.visibility = View.GONE
        } else {
            btnSimpan.visibility = View.VISIBLE
        }

        val dialog = AlertDialog.Builder(this)
            .setView(dialogView)
            .setCancelable(true)
            .create()

        btnSimpan.setOnClickListener {
            val newOutlet = OutletModel(
                etNamaOutlet.text.toString(),
                etNamaSPV.text.toString(),
                etNamaArea.text.toString(),
                etMerkInflator.text.toString(),
                etMerkRegulator.text.toString(),
                etDistribusi.text.toString(),
                etNamaVendor.text.toString(),
                etHargaIsiN2.text.toString().toDoubleOrNull() ?: 0.0,
                selectedLatitude,
                selectedLongitude
            )

            db.collection("outlet")
                .add(newOutlet)
                .addOnSuccessListener {
                    outletList.add(newOutlet)
                    outletAdapter.notifyItemInserted(outletList.size - 1)
                    dialog.dismiss()
                    Toast.makeText(this, "Data berhasil disimpan", Toast.LENGTH_SHORT).show()
                }
                .addOnFailureListener { e ->
                    Toast.makeText(this, "Gagal menyimpan: ${e.message}", Toast.LENGTH_SHORT).show()
                }
        }



        dialog.show()
    }

    fun onDataChanged() {
        outletList.clear()
        db.collection("outlet")
            .get()
            .addOnSuccessListener { result ->
                for (document in result) {
                    val outlet = document.toObject(OutletModel::class.java)
                    outletList.add(outlet)
                }
                outletAdapter.notifyDataSetChanged()
            }
            .addOnFailureListener { e ->
                Toast.makeText(this, "Gagal ambil data: ${e.message}", Toast.LENGTH_SHORT).show()
            }
    }



}
