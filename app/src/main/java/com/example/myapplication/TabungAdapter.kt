package com.example.myapplication

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.google.firebase.firestore.FirebaseFirestore
import android.widget.Toast
import android.widget.ImageButton
import com.google.firebase.auth.FirebaseAuth

class TabungAdapter(private var tabungList: List<TabungModel>) :
    RecyclerView.Adapter<TabungAdapter.TabungViewHolder>() {

    private var filteredList: MutableList<TabungModel> = tabungList.toMutableList()
    private val userEmail = FirebaseAuth.getInstance().currentUser?.email ?: ""

    class TabungViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val noTabung: TextView = view.findViewById(R.id.tvNoTabung)
        val seriTabung: TextView = view.findViewById(R.id.tvSeriTabung)
        val btnHapus: ImageButton = view.findViewById(R.id.btnHapusTabung)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): TabungViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_tabung, parent, false)
        return TabungViewHolder(view)
    }

    override fun onBindViewHolder(holder: TabungViewHolder, position: Int) {
        val tabung = filteredList[position]
        holder.noTabung.text = tabung.noTabung
        holder.seriTabung.text = tabung.seriTabung

        if (userEmail == "admin@gmail.com") {
            holder.btnHapus.visibility = View.VISIBLE
            holder.btnHapus.setOnClickListener {
                val pos = holder.adapterPosition
                if (pos != RecyclerView.NO_POSITION) {
                    val itemToDelete = filteredList[pos]
                    FirebaseFirestore.getInstance().collection("tabung")
                        .document(itemToDelete.documentId)
                        .delete()
                        .addOnSuccessListener {
                            filteredList.removeAt(pos)
                            notifyItemRemoved(pos)
                            Toast.makeText(holder.itemView.context, "Tabung dihapus", Toast.LENGTH_SHORT).show()
                        }
                        .addOnFailureListener { e ->
                            Toast.makeText(holder.itemView.context, "Gagal hapus: ${e.message}", Toast.LENGTH_SHORT).show()
                        }
                }
            }
        } else {
            holder.btnHapus.visibility = View.GONE
        }
    }

    override fun getItemCount(): Int = filteredList.size

    fun filterList(query: String) {
        filteredList = if (query.isEmpty()) {
            tabungList.toMutableList()
        } else {
            tabungList.filter {
                it.noTabung.contains(query, ignoreCase = true) ||
                        it.seriTabung.contains(query, ignoreCase = true)
            }.toMutableList()
        }
        notifyDataSetChanged()
    }

    fun setTabungList(newList: List<TabungModel>) {
        tabungList = newList
        filteredList = newList.toMutableList()
        notifyDataSetChanged()
    }
}
