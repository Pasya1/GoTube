package com.example.myapplication

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

class DeliveryAdapter(private val listData: List<DeliveryHistory>) :
    RecyclerView.Adapter<DeliveryAdapter.ViewHolder>() {

    class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val namaPengiriman: TextView = itemView.findViewById(R.id.tvNamaPengiriman)
        val outlet: TextView = itemView.findViewById(R.id.tvOutlet)
        val kodeTabung: TextView = itemView.findViewById(R.id.tvKodeTabung)
        val statusTabung: TextView = itemView.findViewById(R.id.tvStatusTabung)
        val status: TextView = itemView.findViewById(R.id.tvStatus)
        val tanggal: TextView = itemView.findViewById(R.id.tvTanggal)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_delivery_history, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = listData[position]
        holder.namaPengiriman.text = item.namaPengiriman
        holder.outlet.text = item.outlet
        holder.kodeTabung.text = item.kodeTabung
        holder.statusTabung.text = item.statusTabung
        holder.status.text = item.status
        holder.tanggal.text = item.tanggal
    }

    override fun getItemCount(): Int = listData.size
}
