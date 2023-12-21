<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //method untuk tampilkan data kategori
    public function index()
    {
        $categories = Category::latest()->when(request()->q, function ($categories) {
            $categories = $categories->where("nama_kategori", "like", "%" . request()->q . "%");
        })->paginate(10);
        return view("admin.category.index", compact("categories"));
    }

    //method untuk panggil input data
    public function create()
    {
        return view('admin.category.create');
    }

    //method untuk kirim data dari inputan form ke tabel kategori ke database
    public function store(Request $request)
    {
        // Validasi inputan
        $this->validate($request, [
            'nama_kategori' => 'required|unique:categories',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        // Kode untuk upload gambar
        $image = $request->file('image');
        //kita simpan di kode categories
        $image->storeAs('public/categories', $image->hashName());

        // Data input simpan ke dalam tabel
        $category = Category::create([
            'image' => $image->hashName(),
            'nama_kategori' => $request->nama_kategori
        ]);

        // Kondisi
        if ($category) {
            // Redirect dengan tampilkan pesan
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Kategori']);
        } else {
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Kategori']);
        }
    }

    //method untuk tampilkan data yang mau di ubah
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    //buat method untuk kirimkan data yang diubah di form inputan
    public function update(Request $request, Category $category)
    {
        // Validasi inputan
        $this->validate($request, [
            'nama_kategori' => 'required|unique:categories,nama_kategori,' . $category->id
        ]);

        // Percabangan IF
        if ($request->file('image') == '') {
            $category = Category::findOrfail($category->id);
            $category->update([
                'nama_kategori' => $request->nama_kategori
            ]);
        } else {
            // Hapus dulu gambar sebelumnya
            Storage::disk('local')->delete('public/categories/' . basename($category->image));

            // Upload file gambar yang baru
            //kode untuk upload gambar
            $image = $request->file('image');
            //kita simpan di kode categories
            $image->storeAs('public/categories', $image->hashName());

            // Update data di tabel kategori dengan data baru
            //update data di tabel kategori dengan data baru
            $category = Category::findOrFail($category->id);
            $category->update([
                'nama_kategori' => $request->nama_kategori,
                'image' => $image->hashName()
            ]);
        }
        // Kondisi jika berhasil atau tidak diubah datanya
        if ($category) {
            // Redirect dengan tampilkan pesan
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Disimpan Kedalam Tabel Kategori']);
        } else {
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Disimpan Kedalam Tabel Kategori']);
        }
    }
    //method untuk hapus data
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        Storage::disk('local')->delete('public/categories/' . basename($category->image));
        $category->delete();

        //kondisi berhasil atau tidak hapus datanya
        if ($category) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);


        }

    }
}

