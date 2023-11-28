<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Helper {
    public static function getUser()
    {
        return Auth::guard('kasir')->user();
    }

    public static function formatRupiah($angka) {
        // Menggunakan number_format untuk memformat angka dengan pemisah ribuan dan desimal
        $rupiah = "Rp " . number_format($angka, 0, ',', '.');
        
        return $rupiah;
    }
}
