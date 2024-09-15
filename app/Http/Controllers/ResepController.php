<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data dari model Resep dan menyimpannya dalam variabel $reseps
        $reseps = Resep::all();
        // Mengembalikan view 'reseps.index' dengan data $reseps yang sudah diambil
        return view('reseps.index', compact('reseps'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengembalikan Ke View reseps.create
        return view('reseps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input yang diterima dari request
        $request->validate([
            'name' => 'required', // Field 'name' harus diisi
            'deskripsi' => 'nullable', // Field 'deskripsi' boleh kosong
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file foto 
                                                                    //(boleh kosong, harus gambar, format jpeg, png, jpg, 
                                                                    // ukuran maksimal 2MB)
        ]);

        $photoPath = null; // Inisialisasi variabel untuk menyimpan path foto

        // Cek apakah ada file foto yang di-upload
        if ($request->hasFile('photo')) {
            // Simpan file foto di folder 'photos' di storage publik dan ambil path-nya
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Buat data baru di tabel 'reseps' dengan data dari request
        Resep::create([
            'name' => $request->name, // Simpan nama resep
            'deskripsi' => $request->deskripsi, // Simpan deskripsi resep
            'photo' => $photoPath, // Simpan path foto ke database
        ]);
    

        // Redirect ke halaman index reseps dengan pesan sukses
        return redirect()->route('reseps.index')->with('success', 'Resep Sudah Di Buat');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mencari data resep berdasarkan ID yang diberikan
        $resep = Resep::findOrFail($id);

        // Mencari bahan-bahan yang terkait dengan resep berdasarkan resep_id
        // dan mengurutkan berdasarkan kolom 'position'
        $bahans = Bahan::where('resep_id', $id)->orderBy('position')->get();

        // Mengembalikan view 'reseps.show' dengan data resep dan bahan yang ditemukan
        return view('reseps.show', compact('resep', 'bahans'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resep $resep)
    {
        return view('reseps.edit', compact('resep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resep $resep)
    {
        // Validasi input yang diterima dari request
        $request->validate([
            'name' => 'required', // Field 'name' harus diisi
            'deskripsi' => 'nullable', // Field 'deskripsi' boleh kosong
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto (boleh kosong, 
                                                                        // harus gambar, format jpeg, png, jpg, gif, 
                                                                        // ukuran maksimal 2MB)
        ]);

        $data = $request->all(); // Mengambil semua data dari request

        // Penanganan upload foto
        if ($request->hasFile('photo')) {
            // Menghapus foto lama jika ada
            if ($resep->photo && Storage::exists('public/' . $resep->photo)) {
                Storage::delete('public/' . $resep->photo);
            }

            // Menyimpan foto baru dan menyimpan path-nya di variabel $photoPath
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath; // Memperbarui path foto di data yang akan diupdate
        }

        // Mengupdate data resep dengan data yang baru
        $resep->update($data);

        // Redirect ke halaman indeks reseps dengan pesan sukses
        return redirect()->route('reseps.index')->with('success', 'Resep updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resep $resep)
    {
        $resep->delete();
        return redirect()->route('reseps.index')->with('success', 'Resep Telah Terhapus');
    }
}
