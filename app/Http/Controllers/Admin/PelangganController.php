<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    
    //method untuk tampilkan data Pelanggan
    public function index()
    {
        $Pelanggan = Pelanggan::latest()->when(request()->q, function ($Pelanggan) {
            $Pelanggan = $Pelanggan->where("nama_pelanggan", "like", "%" . request()->q . "%");
        })->paginate(10);
        return view("admin.Pelanggan.index", compact("Pelanggan")); 
    }

    //methode untuk view form input data
    public function create(){
        return view('admin.Pelanggan.create');
    }

    
    //method untuk kirim data dari inputan form ke tabel kategori ke database
    // 'nama_pelanggan','alamat','no_hp','email','tanggal_pernikahan'
    public function store(Request $request)
    {
        // Validasi inputan
        $this->validate($request, [
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'tanggal_pernikahan' => 'required'

        ]);


        // Data input simpan ke dalam tabel
        $Pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'tanggal_pernikahan' => $request->tanggal_pernikahan
        ]);

        // Kondisi
        if ($Pelanggan) {
            // Redirect dengan tampilkan pesan
            return redirect()->route('admin.Pelanggan.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Pelanggan']);
        } else {
            return redirect()->route('admin.Pelanggan.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Pelanggan']);
        }
    } 

}
