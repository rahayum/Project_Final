<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // ... Metode lainnya ...

    // Metode untuk menampilkan form pengeditan data barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.edit', compact('barang'));
    }

    // Metode untuk menyimpan data yang sudah diedit
    public function update(Request $request, $id)
    {
        // Validasi inputan
        $this->validate($request, [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'kat_barang' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
        ]);

        // Cari data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Perbarui data barang dengan data baru
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kat_barang' => $request->kat_barang,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);

        // Redirect dengan tampilkan pesan
        return redirect()->route('admin.barang.index')->with(['success' => 'Data Barang Berhasil Diperbarui']);
    }

    // Metode untuk menghapus data barang
    public function destroy($id)
    {
        // Cari data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Hapus data barang
        $barang->delete();

        // Redirect dengan tampilkan pesan
        return redirect()->route('admin.barang.index')->with(['success' => 'Data Barang Berhasil Dihapus']);
    }
}

