<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    //buat function untuk mass assigment
    protected $fillable = [
        'id_pemesanan','id_pelanggan','tgl_pemesanan','tgl_pernikahan','total_biaya','status_pemesanan'
    ];

    //buat metode untuk relasi  
    public function Pelanggan(){
        return $this->hasMany(Pelanggan::class); //jenis relasi one to many

    }

    public function Pembayaran(){
        return $this->hasOne(Pembayaran::class); //jenis relasi one to one
        
    }


}
