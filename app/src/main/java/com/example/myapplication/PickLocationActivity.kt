package com.example.myapplication

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import androidx.appcompat.app.AppCompatActivity
import org.osmdroid.config.Configuration
import org.osmdroid.util.GeoPoint
import org.osmdroid.views.MapView
import org.osmdroid.tileprovider.tilesource.TileSourceFactory

class PickLocationActivity : AppCompatActivity() {

    private lateinit var mapView: MapView
    private lateinit var btnSimpanLokasi: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        // Inisialisasi osmdroid
        Configuration.getInstance().load(applicationContext, getSharedPreferences("osm", MODE_PRIVATE))
        setContentView(R.layout.activity_pick_location)

        mapView = findViewById(R.id.mapView)
        btnSimpanLokasi = findViewById(R.id.btnSimpanLokasi)

        mapView.setTileSource(TileSourceFactory.MAPNIK)
        mapView.setMultiTouchControls(true)

        val startPoint = GeoPoint(-6.2, 106.8) // Jakarta
        mapView.controller.setZoom(14.0)
        mapView.controller.setCenter(startPoint)

        btnSimpanLokasi.setOnClickListener {
            val center = mapView.mapCenter as GeoPoint
            val resultIntent = Intent().apply {
                putExtra("latitude", center.latitude)
                putExtra("longitude", center.longitude)
            }
            setResult(RESULT_OK, resultIntent)
            finish()
        }
    }

    override fun onResume() {
        super.onResume()
        mapView.onResume()
    }

    override fun onPause() {
        super.onPause()
        mapView.onPause()
    }
}
