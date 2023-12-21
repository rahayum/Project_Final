<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
   //method untuk tampilkan data Pembayaran
   public function index()
   {
       $Pembayaran = Pembayaran::latest()->when(request()->q, function ($Pembayaran) {
           $Pembayaran = $Pembayaran->where("tanggal_pemesanan", "like", "%" . request()->q . "%");
       })->paginate(10);
       return view("admin.Pembayaran.index", compact("Pembayaran")); 
   }

   //methode untuk view form input data
   public function create(){
       return view('admin.Pembayaran.create');
   }

   
   //method untuk kirim data dari inputan form ke tabel kategori ke database
   
   public function store(Request $request)
   {
       // Validasi inputan
       $this->validate($request, [
           'metode_pembayaran' => 'required',
           'tanggal_pembayaran' => 'required',
           'jumlah_pembayaran' => 'required'
           
           

       ]);


       // Data input simpan ke dalam tabel
       $Pembayaran = Pembayaran::create([
          'metode_pembayaran' => $request->metode_pembayaran,
          'tanggal_pembayaran' => $request->tanggal_pembayaran,
          'jumlah_pembayaran' => $request->jumlah_pembayaran
          
       ]);

       // Kondisi
       if ($Pembayaran) {
           // Redirect dengan tampilkan pesan
           return redirect()->route('admin.Pembayaran.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Pembayaran']);
       } else {
           return redirect()->route('admin.Pembayaran.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Pembayaran']);
       }
   } 
}
