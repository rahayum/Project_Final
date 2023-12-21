<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
     //method untuk tampilkan data Pemesanan
     public function index()
     {
         $Pemesanan = Pemesanan::latest()->when(request()->q, function ($Pemesanan) {
             $Pemesanan = $Pemesanan->where("tanggal_pemesanan", "like", "%" . request()->q . "%");
         })->paginate(10);
         return view("admin.Pemesanan.index", compact("Pemesanan")); 
     }
 
     //methode untuk view form input data
     public function create(){
         return view('admin.Pemesanan.create');
     }
 
     
     //method untuk kirim data dari inputan form ke tabel kategori ke database
     
     public function store(Request $request)
     {
         // Validasi inputan
         $this->validate($request, [
             'tanggal_pemesanan' => 'required',
             'tanggal_pernikahan' => 'required',
             'total_biaya' => 'required',
             'status_pemesanan' => 'required'
             
 
         ]);
 
 
         // Data input simpan ke dalam tabel
         $Pemesanan = Pemesanan::create([
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'total_biaya' => $request->total_biaya,
            'status_pemesanan' => $request->status_pemesanan
         ]);
 
         // Kondisi
         if ($Pemesanan) {
             // Redirect dengan tampilkan pesan
             return redirect()->route('admin.pemesanan.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Pemesanan']);
         } else {
             return redirect()->route('admin.Pemesanan.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Pemesanan']);
         }
     } 
}
