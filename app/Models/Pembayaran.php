<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable =[
        'id_pembayaran','id_pemesanan','metode_pembayaran','tanggal_pembayaran','jumlah_pembayaran'
    ];

     //buat metode untuk relasi  
     public function Pemesanan(){
        return $this->hasOne(Pemesanan::class); //jenis relasi one to one

    }
}
