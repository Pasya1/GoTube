package com.example.myapplication

import android.app.DatePickerDialog
import android.content.Intent
import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.app.AppCompatDelegate
import java.util.*
import com.google.firebase.firestore.FirebaseFirestore


class DeliveryActivity : AppCompatActivity() {

    private lateinit var etTanggal: EditText
    private lateinit var etKodeTabung: EditText
    private lateinit var etNamaPenerima: EditText
    private lateinit var spinnerOutlet: Spinner
    private lateinit var rgTabung: RadioGroup
    private lateinit var btnSubmit: Button
    private lateinit var btnBack: ImageButton
    private lateinit var db: FirebaseFirestore
    private lateinit var spinnerTabung: Spinner

    private val outletList = mutableListOf<String>()
    private val tabungList = mutableListOf<String>()




    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
        setContentView(R.layout.activity_delivery)

        db = FirebaseFirestore.getInstance()
        outletList.add("-- Pilih --")
        tabungList.add("-- Pilih --")

        spinnerOutlet = findViewById(R.id.spinnerOutlet)
        spinnerTabung = findViewById(R.id.spinnerTabung)

        // Ambil data outlet dari Firebase
        db.collection("outlet").get().addOnSuccessListener { documents ->
            for (doc in documents) {
                val namaOutlet = doc.getString("namaOutlet") ?: ""
                outletList.add(namaOutlet)
            }
            val outletAdapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, outletList)
            outletAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
            spinnerOutlet.adapter = outletAdapter
        }

        // Ambil data tabung dari Firebase
        db.collection("tabung").get().addOnSuccessListener { documents ->
            for (doc in documents) {
                val noTabung = doc.getString("noTabung") ?: ""
                tabungList.add(noTabung)
            }
            val tabungAdapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, tabungList)
            tabungAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
            spinnerTabung.adapter = tabungAdapter
        }


        // Inisialisasi View
        etTanggal = findViewById(R.id.etTanggal)
        etNamaPenerima = findViewById(R.id.etNamaPenerima)
        spinnerOutlet = findViewById(R.id.spinnerOutlet)
        rgTabung = findViewById(R.id.rgTabung)
        btnSubmit = findViewById(R.id.btnSubmit)
        btnBack = findViewById(R.id.btnBack)


        // Set DatePicker
        etTanggal.setOnClickListener {
            val calendar = Calendar.getInstance()
            val year = calendar.get(Calendar.YEAR)
            val month = calendar.get(Calendar.MONTH)
            val day = calendar.get(Calendar.DAY_OF_MONTH)

            val dateListener = DatePickerDialog.OnDateSetListener { _, year, month, day ->
                etTanggal.setText("$day/${month + 1}/$year")
            }
            DatePickerDialog(this, dateListener, year, month, day).show()

        }
        btnBack.setOnClickListener {
            finish() // Kembali ke HomeActivity tanpa membuat instance baru
        }

        // Tombol Submit
        btnSubmit.setOnClickListener {
            val tanggal = etTanggal.text.toString().trim()
            val namaPenerima = etNamaPenerima.text.toString().trim()
            val outlet = spinnerOutlet.selectedItem?.toString() ?: ""
            val kodeTabung = spinnerTabung.selectedItem?.toString() ?: ""

            val selectedRadioButtonId = rgTabung.checkedRadioButtonId
            val statusTabung = if (selectedRadioButtonId != -1) {
                findViewById<RadioButton>(selectedRadioButtonId).text.toString()
            } else {
                ""
            }

            if (tanggal.isEmpty() || namaPenerima.isEmpty() || outlet == "-- Pilih --" || kodeTabung == "-- Pilih --" || statusTabung.isEmpty()) {
                Toast.makeText(this, "Semua field wajib diisi!", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            val delivery = DeliveryHistory(
                outlet, tanggal, kodeTabung, namaPenerima, statusTabung,
                status = "Pending"
            )

            db.collection("delivery")
                .add(delivery)
                .addOnSuccessListener {
                    Toast.makeText(this, "Data berhasil disimpan ke Firebase", Toast.LENGTH_SHORT).show()
                    setResult(RESULT_OK)
                    finish()

                }
                .addOnFailureListener { e ->
                    Toast.makeText(this, "Gagal menyimpan data: ${e.message}", Toast.LENGTH_LONG).show()
                }
        }

    }
}
