<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    public function index()
{
    return Barang::with('kategori')->get()->map(function ($barang) {
        $barang->gambar = $barang->gambar ? asset('storage/' . $barang->gambar) : null;
        return $barang;
    });
}

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'kategori_id' => 'required|exists:kategoris,id',
        'gambar' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Proses gambar jika ada
    $gambarPath = null;
    if ($request->hasFile('gambar')) {
        $gambarPath = $request->file('gambar')->store('images/barangs', 'public');
    }

    // Simpan data ke database
    $barang = Barang::create([
        'nama' => $request->nama,
        'harga' => $request->harga,
        'kategori_id' => $request->kategori_id,
        'gambar' => $gambarPath,
    ]);

    return response()->json($barang->load('kategori'), 201);
}
    

    public function show($id)
    {
        return Barang::with('kategori')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Cari data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses file gambar jika ada dalam permintaan
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('images/barangs', 'public');
            $request->merge(['gambar' => $gambarPath]); // Tambahkan path gambar ke request
        }

        // Update data barang
        $barang->update($request->all());

        // Kembalikan respons JSON
        return response()->json($barang->load('kategori'), 200);
    }
    
    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json(['message' => 'Barang deleted'], 200);
    }

}
