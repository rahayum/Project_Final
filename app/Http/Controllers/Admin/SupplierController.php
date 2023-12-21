<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //method untuk tampilkan data kategori
    public function index()
    {
        $supplier = Supplier::latest()->when(request()->q, function ($supplier) {
            $supplier = $supplier->where("nama_supplier", "like", "%" . request()->q . "%");
        })->paginate(10);
        return view("admin.supplier.index", compact("supplier"));
    }

    // method untuk view form input data
    public function create()
    {
        return view('admin.supplier.create');
    }

    //method untuk kirim data dari inputan form ke tabel kategori ke database
    public function store(Request $request)
    {
        // Validasi inputan
        $this->validate($request, [
            'nama_supplier' => 'required|min:5',
            'no_kontak' => 'required|min:12',
            'alamat' => 'required',
            'keterangan' => 'required'

        ]);

        // Data input simpan ke dalam tabel
        $supplier = Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'no_kontak' => $request->no_kontak,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan
        ]);

        // Kondisi apakah data berhasil disimpan atau tidak
        if ($supplier) {
            // Redirect dengan tampilkan pesan
            return redirect()->route('admin.supplier.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Supplier']);
        } else {
            return redirect()->route('admin.supplier.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Supplier']);
        }
    }
    // method untuk  tampilkan data yang mau diubah
    public function edit(supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    //buat method untuk kirimkan data yang diubah di form inputan
    public function update(Request $request, Supplier $supplier)
    {
        // Validasi inputan
        $this->validate($request, [
            'nama_supplier' => 'required|min:5',
            'no_kontak' => 'required|min:12',
            'alamat' => 'required',
            'keterangan' => 'required'
        ]);

        $category = supplier::findOrFail($supplier->id);
        $category->update([
            'nama_supplier' => $request->nama_supplier,
            'no_kontak' => $request->no_kontak,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan
        ]);

        // Kondisi jika berhasil atau tidak diubah datanya
        if ($supplier) {
            // Redirect dengan tampilkan pesan
            return redirect()->route('admin.supplier.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Supplier']);
        } else {
            return redirect()->route('admin.supplier.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Supplier']);
        }
    }
    //method untuk hapus data
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        //hapus data
        $supplier->delete();

        //kondisi berhasil atau tidak hapus datanya
        if ($supplier) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);


        }

    }
}
