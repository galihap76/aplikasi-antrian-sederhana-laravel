<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Antrian extends Controller
{
   // Fungsi untuk mengambil nomor antrian terbaru dari database
   public function getAntrian(){
    $antrian = DB::table('tbl_nomor_antrian')->select('nomor_antrian')->value('nomor_antrian');
    
    echo $antrian;
}
 
    public function updateAntrian(Request $request)
    {
        // Mengambil nomor antrian terbaru dari database
        $currentAntrian = DB::table('tbl_nomor_antrian')->select('nomor_antrian')->first();
        // Menambah nomor antrian sebanyak satu
        $newAntrian = $currentAntrian->nomor_antrian + 1;

        // Update nomor antrian terbaru ke dalam database
        DB::table('tbl_nomor_antrian')
              ->where('id', 1)
              ->update(['nomor_antrian' => $newAntrian]);

        // Mengembalikan nomor antrian terbaru sebagai respons
        return $newAntrian;
    }
}
