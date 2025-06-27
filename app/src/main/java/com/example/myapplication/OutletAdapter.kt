package com.example.myapplication

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.EditText
import android.widget.ImageButton
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import java.text.NumberFormat
import java.util.Locale
import org.osmdroid.tileprovider.tilesource.TileSourceFactory
import org.osmdroid.util.GeoPoint
import org.osmdroid.views.MapView
import org.osmdroid.views.overlay.Marker
import org.osmdroid.config.Configuration
import androidx.preference.PreferenceManager
import android.widget.Toast
import androidx.appcompat.app.AlertDialog
import com.google.firebase.firestore.FirebaseFirestore




class OutletAdapter(
    private val outletList: MutableList<OutletModel>,
    private val isAdmin: Boolean
) :
    RecyclerView.Adapter<OutletAdapter.OutletViewHolder>() {

    class OutletViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvNamaOutlet: TextView = view.findViewById(R.id.tvNamaOutlet)
        val tvNamaSPV: TextView = view.findViewById(R.id.tvNamaSPV)
        val tvNamaVendor: TextView = view.findViewById(R.id.tvNamaVendor)
        val tvNamaArea: TextView = view.findViewById(R.id.tvNamaArea)
        val tvMerkInflator: TextView = view.findViewById(R.id.tvMerkInflator)
        val tvMerkRegulator: TextView = view.findViewById(R.id.tvMerkRegulator)
        val tvDistribusiBy: TextView = view.findViewById(R.id.tvDistribusiBy)
        val tvHargaIsi: TextView = view.findViewById(R.id.tvHargaIsi)

        val btnEdit: ImageButton = view.findViewById(R.id.btnEdit)
        val btnHapus: ImageButton = view.findViewById(R.id.btnHapus)
        val detailLayout: View = view.findViewById(R.id.cardDetail) // CardView detail
        val mapView: MapView = view.findViewById(R.id.mapView)

    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): OutletViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_outlet, parent, false)
        return OutletViewHolder(view)
    }

    override fun onBindViewHolder(holder: OutletViewHolder, position: Int) {
        val outlet = outletList[position]

        // Format harga ke bentuk ribuan (contoh: 120.000)
        val formatter = NumberFormat.getInstance(Locale("id", "ID"))
        holder.tvHargaIsi.text = formatter.format(outlet.hargaIsiN2)
        // Setup MapView
        Configuration.getInstance().load(holder.itemView.context,
            androidx.preference.PreferenceManager.getDefaultSharedPreferences(holder.itemView.context))

        holder.mapView.setTileSource(TileSourceFactory.MAPNIK)
        holder.mapView.setMultiTouchControls(true)
        holder.mapView.controller.setZoom(14.0)

        val geoPoint = GeoPoint(outlet.latitude, outlet.longitude)
        holder.mapView.controller.setCenter(geoPoint)

        // Tambahkan marker
        val marker = Marker(holder.mapView)
        marker.position = geoPoint
        marker.setAnchor(Marker.ANCHOR_CENTER, Marker.ANCHOR_BOTTOM)
        marker.title = outlet.namaOutlet

        holder.mapView.overlays.clear()
        holder.mapView.overlays.add(marker)
        holder.mapView.invalidate()


        // Set data outlet utama
        holder.tvNamaOutlet.text = outlet.namaOutlet
        holder.tvNamaSPV.text = outlet.namaSPV
        holder.tvNamaVendor.text = outlet.namaVendor
        holder.tvNamaArea.text = outlet.namaArea
        holder.tvMerkInflator.text = outlet.merkInflator
        holder.tvMerkRegulator.text = outlet.merkRegulator
        holder.tvDistribusiBy.text = outlet.distribusiToOutletBy


        // Tampilkan atau sembunyikan detail berdasarkan status isExpanded
        holder.detailLayout.visibility = if (outlet.isExpanded) View.VISIBLE else View.GONE

        // Tambahkan klik listener pada card utama
        holder.itemView.setOnClickListener {
            outlet.isExpanded = !outlet.isExpanded
            notifyItemChanged(position) // Update tampilan item yang diklik
        }
        // Tombol hapus (ikon tempat sampah)
        holder.btnHapus.setOnClickListener {
            val context = holder.itemView.context

            AlertDialog.Builder(context)
                .setTitle("Hapus Data")
                .setMessage("Yakin ingin menghapus outlet \"${outlet.namaOutlet}\"?")
                .setPositiveButton("Ya") { _, _ ->
                    FirebaseFirestore.getInstance()
                        .collection("outlet")
                        .whereEqualTo("namaOutlet", outlet.namaOutlet)
                        .get()
                        .addOnSuccessListener { documents ->
                            for (doc in documents) {
                                doc.reference.delete()
                            }
                            (outletList as MutableList).removeAt(position)
                            notifyItemRemoved(position)
                            Toast.makeText(context, "Outlet dihapus", Toast.LENGTH_SHORT).show()
                        }
                        .addOnFailureListener { e ->
                            Toast.makeText(context, "Gagal hapus: ${e.message}", Toast.LENGTH_SHORT).show()
                        }
                }
                .setNegativeButton("Batal", null)
                .show()
        }


        holder.btnEdit.setOnClickListener {
            val context = holder.itemView.context
            val dialogView = LayoutInflater.from(context).inflate(R.layout.dialog_tambah_outlet, null)
            val btnSimpan = dialogView.findViewById<Button>(R.id.btnSimpan)
            btnSimpan.visibility = View.GONE

            val etNamaOutlet = dialogView.findViewById<EditText>(R.id.etNamaOutlet)
            val etNamaSPV = dialogView.findViewById<EditText>(R.id.etNamaSPV)
            val etNamaArea = dialogView.findViewById<EditText>(R.id.etNamaArea)
            val etMerkInflator = dialogView.findViewById<EditText>(R.id.etMerkInflator)
            val etMerkRegulator = dialogView.findViewById<EditText>(R.id.etMerkRegulator)
            val etDistribusi = dialogView.findViewById<EditText>(R.id.etDistribusi)
            val etNamaVendor = dialogView.findViewById<EditText>(R.id.etNamaVendor)
            val etHargaIsiN2 = dialogView.findViewById<EditText>(R.id.etHargaIsiN2)

            // Isi dengan data lama
            etNamaOutlet.setText(outlet.namaOutlet)
            etNamaSPV.setText(outlet.namaSPV)
            etNamaArea.setText(outlet.namaArea)
            etMerkInflator.setText(outlet.merkInflator)
            etMerkRegulator.setText(outlet.merkRegulator)
            etDistribusi.setText(outlet.distribusiToOutletBy)
            etNamaVendor.setText(outlet.namaVendor)
            etHargaIsiN2.setText(outlet.hargaIsiN2.toString())

            AlertDialog.Builder(context)
                .setTitle("Edit Outlet")
                .setView(dialogView)
                .setPositiveButton("Simpan") { _, _ ->
                    val db = FirebaseFirestore.getInstance()
                    db.collection("outlet")
                        .whereEqualTo("namaOutlet", outlet.namaOutlet) // Atau pakai ID unik kalau ada
                        .get()
                        .addOnSuccessListener { documents ->
                            for (doc in documents) {
                                val updateData = mapOf(
                                    "namaOutlet" to etNamaOutlet.text.toString(),
                                    "namaSPV" to etNamaSPV.text.toString(),
                                    "namaArea" to etNamaArea.text.toString(),
                                    "merkInflator" to etMerkInflator.text.toString(),
                                    "merkRegulator" to etMerkRegulator.text.toString(),
                                    "distribusiToOutletBy" to etDistribusi.text.toString(),
                                    "namaVendor" to etNamaVendor.text.toString(),
                                    "hargaIsiN2" to (etHargaIsiN2.text.toString().toDoubleOrNull() ?: 0.0)
                                )

                                doc.reference.update(updateData)
                                    .addOnSuccessListener {
                                        Toast.makeText(context, "Data berhasil diupdate", Toast.LENGTH_SHORT).show()

                                        // Trigger refresh di OutletActivity
                                        if (context is OutletActivity) {
                                            context.onDataChanged()
                                        }
                                    }

                                    .addOnFailureListener {
                                        Toast.makeText(context, "Gagal update: ${it.message}", Toast.LENGTH_SHORT).show()
                                    }
                            }
                        }
                }
                .setNegativeButton("Batal", null)
                .show()
        }

        if (!isAdmin) {
            holder.btnEdit.visibility = View.GONE
            holder.btnHapus.visibility = View.GONE
        }


    }

    override fun getItemCount(): Int = outletList.size
}
