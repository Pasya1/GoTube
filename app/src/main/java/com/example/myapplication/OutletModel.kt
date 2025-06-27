package com.example.myapplication

data class OutletModel(
    var namaOutlet: String = "",
    var namaSPV: String = "",
    var namaArea: String = "",
    var merkInflator: String = "",
    var merkRegulator: String = "",
    var distribusiToOutletBy: String = "",
    var namaVendor: String = "",
    var hargaIsiN2: Double = 0.0,
    var latitude: Double = 0.0,    // tambah koordinat
    var longitude: Double = 0.0,
    var isExpanded: Boolean = false
)

