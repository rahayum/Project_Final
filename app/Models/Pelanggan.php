<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
     //buat function untuk mass assigment
     protected $fillable = [
        'nama_pelanggan','alamat','no_hp','email','tanggal_pernikahan'
     ];

     //methode untuk relasional tabel
     public function Pemesanan(){
      return $this->belongsTo(Pemesanan::class); //jenis relasi many to one
      
  }
        
} 
