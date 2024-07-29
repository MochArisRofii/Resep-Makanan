<?php

namespace App\Http\Controllers;

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
        $reseps = Resep::all();
        return view('reseps.index', compact('reseps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reseps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file foto
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Resep::create([
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'photo' => $photoPath, // Simpan path foto ke database
        ]);


        return redirect()->route('reseps.index')->with('success', 'Resep Sudah Di Buat');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resep = Resep::findOrFail($id);
        $bahans = $resep->bahans; // Mengambil semua bahan terkait dengan resep
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
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($resep->photo && Storage::exists('public/' . $resep->photo)) {
                Storage::delete('public/' . $resep->photo);
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath;
        }

        $resep->update($data);

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
