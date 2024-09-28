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
    public function index(Request $request)
    {
        $reseps = Resep::all();

        // Mengecek apakah request adalah API request atau web request
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $reseps
            ], 200);
        }

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Penanganan upload foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Buat data baru di tabel 'reseps' dengan data yang telah divalidasi
        $resep = Resep::create([
            'name' => $validatedData['name'],
            'deskripsi' => $validatedData['deskripsi'],
            'user_id' => $validatedData['user_id'] ?? null,
            'photo' => $photoPath,
        ]);

        // Respon berdasarkan tipe request
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resep berhasil dibuat!',
                'data' => $resep,
            ], 201);
        }

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil dibuat!');
    }



    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        $resep = Resep::findOrFail($id);
        $bahans = Bahan::where('resep_id', $id)->orderBy('position')->get();

        // Cek apakah request adalah API request atau web request
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'resep' => $resep,
                'bahans' => $bahans,
            ], 200);
        }

        return view('reseps.show', compact('resep', 'bahans'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resep $resep, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $resep,
            ], 200);
        }

        return view('reseps.edit', compact('resep'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resep $resep)
    {
        // Validasi input yang diterima dari request
        $validatedData = $request->validate([
            'name' => 'required|', // Field 'name' harus diisi
            'deskripsi' => 'nullable', // Field 'deskripsi' boleh kosong
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto harus dalam format yang benar jika diisi
        ]);

        // Ambil data yang valid
        $data = $request->only(['name', 'deskripsi']);

        // Penanganan upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($resep->photo && Storage::exists('public/' . $resep->photo)) {
                Storage::delete('public/' . $resep->photo);
            }

            // Simpan foto baru dan update path-nya
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // Update data resep
        $resep->update($data);

        // Cek jika permintaan adalah API
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resep berhasil diperbarui!',
                'data' => $resep,
            ], 200);
        }

        // Jika bukan API, redirect ke halaman index
        return redirect()->route('reseps.index')->with('success', 'Resep berhasil diperbarui!');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resep $resep, Request $request)
    {
        // Hapus foto jika ada sebelum menghapus resep
        if ($resep->photo && Storage::exists('public/' . $resep->photo)) {
            Storage::delete('public/' . $resep->photo);
        }

        $resep->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resep berhasil dihapus!',
            ], 200);
        }

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil dihapus!');
    }
}
