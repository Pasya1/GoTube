package com.example.myapplication

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.firestore.FirebaseFirestore
import android.widget.Toast
import com.google.firebase.auth.FirebaseAuth

class RiwayatAdapter(
    private var riwayatList: List<RiwayatModel>,
    private val userEmail: String
) :
    RecyclerView.Adapter<RiwayatAdapter.RiwayatViewHolder>() {

    private var riwayatFilteredList = riwayatList.toMutableList()

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): RiwayatViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_riwayat, parent, false)
        return RiwayatViewHolder(view)
    }

    override fun onBindViewHolder(holder: RiwayatViewHolder, position: Int) {
        val item = riwayatFilteredList[position]
        holder.tvOutlet.text = item.outlet
        holder.tvKodeTabung.text = item.kodeTabung
        holder.tvTanggal.text = item.tanggal
        holder.tvStatus.text = item.status
        holder.tvNamaPengiriman.text = item.namaPengiriman
        holder.tvStatusTabung.text = item.statusTabung

        val db = FirebaseFirestore.getInstance()

        // Tampilkan tombol jika status = Pending
        if (item.status.equals("Pending", ignoreCase = true)) {
            holder.btnEdit.visibility = View.GONE
            holder.btnHapus.visibility = View.VISIBLE
            holder.btnAcc.visibility = View.VISIBLE

            if (userEmail == "admin@gmail.com") {
                // Admin: tampilkan semua
                holder.btnEdit.visibility = View.GONE
                holder.btnHapus.visibility = View.VISIBLE
                holder.btnAcc.visibility = View.VISIBLE
            } else {
                // Non-admin: hanya bisa hapus
                holder.btnEdit.visibility = View.GONE
                holder.btnHapus.visibility = View.VISIBLE
                holder.btnAcc.visibility = View.GONE
            }

        } else {
            // Selain status Pending: sembunyikan semua
            holder.layoutAdminActions.visibility = View.GONE
        }


        // EDIT tombol (form sudah muncul, jadi tidak perlu diubah)
        holder.btnEdit.setOnClickListener {
            // Bisa tambahkan logika atau buka form edit di activity
            Toast.makeText(holder.itemView.context, "Edit data", Toast.LENGTH_SHORT).show()
        }

        // HAPUS tombol
        holder.btnHapus.setOnClickListener {
            db.collection("delivery").document(item.documentId)
                .delete()
                .addOnSuccessListener {
                    Toast.makeText(holder.itemView.context, "Berhasil dihapus", Toast.LENGTH_SHORT).show()
                    val itemId = item.documentId
                    val index = riwayatFilteredList.indexOfFirst { it.documentId == itemId }
                    if (index != -1) {
                        riwayatFilteredList.removeAt(index)
                        notifyItemRemoved(index)
                    }

                }
                .addOnFailureListener { e ->
                    Toast.makeText(holder.itemView.context, "Gagal hapus: ${e.message}", Toast.LENGTH_SHORT).show()
                }
        }

        // ACC tombol dengan dialog konfirmasi
        holder.btnAcc.setOnClickListener {
            val context = holder.itemView.context

            val options = arrayOf("Konfirmasi", "Tolak")
            val builder = androidx.appcompat.app.AlertDialog.Builder(context)
            builder.setTitle("Pilih Aksi")
            builder.setItems(options) { dialog, which ->
                val newStatus = if (which == 0) "Confirmed" else "Ditolak"
                db.collection("delivery").document(item.documentId)
                    .update("status", newStatus)
                    .addOnSuccessListener {
                        Toast.makeText(context, "Status diubah jadi $newStatus", Toast.LENGTH_SHORT).show()
                        riwayatFilteredList[position] = item.copy(status = newStatus)
                        notifyItemChanged(position)
                    }
                    .addOnFailureListener { e ->
                        Toast.makeText(context, "Gagal ubah status: ${e.message}", Toast.LENGTH_SHORT).show()
                    }
            }
            builder.setNegativeButton("Batal", null)
            builder.show()
        }

        when (item.status.lowercase()) {
            "pending" -> holder.tvStatus.setTextColor(holder.itemView.context.getColor(android.R.color.holo_orange_dark))
            "confirmed" -> holder.tvStatus.setTextColor(holder.itemView.context.getColor(android.R.color.holo_green_dark))
            "ditolak" -> holder.tvStatus.setTextColor(holder.itemView.context.getColor(android.R.color.holo_red_dark))
            else -> holder.tvStatus.setTextColor(holder.itemView.context.getColor(android.R.color.black))
        }

    }


    override fun getItemCount(): Int {
        return riwayatFilteredList.size
    }

    fun filter(query: String) {
        riwayatFilteredList = if (query.isEmpty()) {
            riwayatList.toMutableList()
        } else {
            riwayatList.filter {
                it.outlet.contains(query, ignoreCase = true) ||
                        it.kodeTabung.contains(query, ignoreCase = true) ||
                        it.status.contains(query, ignoreCase = true)
            }.toMutableList()
        }
        notifyDataSetChanged()
    }

    class RiwayatViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvOutlet: TextView = itemView.findViewById(R.id.tvOutlet)
        val tvKodeTabung: TextView = itemView.findViewById(R.id.tvKodeTabung)
        val tvTanggal: TextView = itemView.findViewById(R.id.tvTanggal)
        val tvStatus: TextView = itemView.findViewById(R.id.tvStatus)
        val tvNamaPengiriman: TextView = itemView.findViewById(R.id.tvNamaPengiriman)
        val tvStatusTabung: TextView = itemView.findViewById(R.id.tvStatusTabung)

        val btnEdit: View = itemView.findViewById(R.id.btnEdit)
        val btnHapus: View = itemView.findViewById(R.id.btnHapus)
        val btnAcc: View = itemView.findViewById(R.id.btnAcc)
        val layoutAdminActions: View = itemView.findViewById(R.id.layoutAdminActions)
    }

    fun updateData(newList: List<RiwayatModel>) {
        this.riwayatList = newList
        this.riwayatFilteredList = newList.toMutableList()
        notifyDataSetChanged()
    }

}
