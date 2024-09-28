<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data dari model Bahan
        $bahans = Bahan::all();

        // Jika permintaan adalah untuk API (JSON), kembalikan respons JSON
        if (request()->expectsJson()) {
            return response()->json($bahans);
        }

        // Mengirim data $bahans ke view 'reseps.index'
        return view('reseps.index', compact('bahans'));
    }

    public function create($resep_id)
    {
        // Mencari Data Resep berdasarkan id
        $resep = Resep::findOrFail($resep_id);

        return view('bahans.create', compact('resep'));
    }

    // Menyimpan bahan baru
    public function store(Request $request)
    {
        // Validasi input yang diterima dari request
        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'resep_id' => 'required|exists:reseps,id',
        ]);

        // Menyimpan bahan baru
        $bahan = Bahan::create($request->all());

        // Jika permintaan adalah untuk API (JSON), kembalikan respons JSON
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Bahan created successfully.',
                'data' => $bahan
            ]);
        }

        // Redirect ke halaman detail resep setelah bahan berhasil ditambahkan
        return redirect()->route('reseps.show', $request->resep_id)->with('success', 'Bahan created successfully.');
    }

    public function show(Bahan $bahan)
    {
        // Jika permintaan adalah untuk API (JSON), kembalikan respons JSON
        if (request()->expectsJson()) {
            return response()->json(data: $bahan);
        }

        // Mengembalikan Ke Halaman 'reseps.show'
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
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'resep_id' => 'required|exists:reseps,id',
            'position' => 'nullable|integer',
        ]);

        $bahan->update($request->all()); // Mengupdate Bahan

        // Jika permintaan adalah untuk API (JSON), kembalikan respons JSON
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Bahan updated successfully.', 'data' => $bahan]);
        }

        return redirect()->route('reseps.show', $bahan->resep_id)->with('success', 'Bahan updated successfully.');
    }

    public function destroy(Bahan $bahan)
    {
        $resepId = $bahan->resep_id; // Ambil ID resep yang terkait dengan bahan
        $bahan->delete(); // Menghapus Bahan

        // Jika permintaan adalah untuk API (JSON), kembalikan respons JSON
        if (request()->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Bahan deleted successfully.']);
        }

        // Redirect ke halaman resep setelah menghapus bahan
        return redirect()->route('reseps.show', $resepId)->with('success', 'Bahan deleted successfully.');
    }

    public function updatePosition(Request $request)
    {
        $positions = $request->input('positions');

        // Validasi format data
        if (!is_array($positions)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data format']);
        }

        try {
            // Mulai transaksi untuk memastikan konsistensi data
            DB::transaction(function () use ($positions) {
                foreach ($positions as $index => $id) {
                    $bahan = Bahan::find($id);
                    if ($bahan) {
                        $bahan->position = $index;
                        $bahan->save();
                    } else {
                        // Jika data tidak ditemukan, bisa menambahkan log atau menangani kasus ini sesuai kebutuhan
                        throw new \Exception("Bahan with ID $id not found");
                    }
                }
            });

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Tangani pengecualian dan kirim respons dengan pesan kesalahan
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
