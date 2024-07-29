<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Resep;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahans = Bahan::all();
        return view('reseps.index', compact('bahans'));
    }

    public function create($resep_id)
    {
        /// Mencari Data Resep berdasarkan id jika tidak ketemu akan muncul respon 404 atau not found
        $resep = Resep::findOrFail($resep_id);

        return view('bahans.create', compact('resep'));
    }
    
    // Menyimpan bahan baru
    public function store(Request $request)
    {
        $request->validate([
            // Field name wajib diisi, harus berupa string, dan maksimal 255 karakter
            'name' => 'required|string|max:255',

            // Field 'deskripsi' wajib diisi dan harus berupa string
            'deskripsi' => 'require d|string',

            // Field 'quantity' wajib diisi dan harus berupa integer (bilangan bulat)
            'quantity' => 'required|integer',

            // Field 'unit' wajib diisi dan harus berupa string (misalnya "gram", "kg")
            'unit' => 'required|string',

            // Field 'resep_id' wajib diisi dan harus sesuai dengan id yang ada di tabel 'reseps'
            'resep_id' => 'required|exists:reseps,id',
        ]);

        // Menyimpan bahan baru
        Bahan::create($request->all());

        // Redirect ke halaman detail resep setelah bahan berhasil ditambahkan
        return redirect()->route('reseps.show', $request->resep_id)->with('success', 'Bahan created successfully.');
    }

    public function show(Bahan $bahan)
    {
        return view('reseps.show', compact('bahan'));
    }

    public function edit(Bahan $bahan)
    {
        $reseps = Resep::all(); // Ambil semua resep untuk dipilih
        return view('bahans.edit', compact('bahan', 'reseps'));
    }

    public function update(Request $request, Bahan $bahan)
    {
        $request->validate([
            'name' => 'required', // Field 'name' wajib diisi
            'quantity' => 'required|numeric', // Field 'quantity' wajib diisi dan harus berupa nilai numerik (bisa integer atau float)
            'unit' => 'required', // Field 'unit' wajib diisi
            'resep_id' => 'required|exists:reseps,id', // Validasi bahwa resep_id harus ada di tabel reseps
        ]);

        $bahan->update($request->all()); // Mengupdate Bahan Menggunakan request all()

        return redirect()->route('reseps.show', $bahan->resep_id)->with('success', 'Bahan updated successfully.');
    }

    public function destroy(Bahan $bahan)
    {
        $resepId = $bahan->resep_id; // Ambil ID resep yang terkait dengan bahan
        $bahan->delete(); // Menghapus Bahan Menggunakan Delete

        // Meredirect ke Halaman Resep.Show setelah Menghapus Suatu Bahan
        return redirect()->route('reseps.show', $resepId)->with('success', 'Bahan deleted successfully.');
    }
}
