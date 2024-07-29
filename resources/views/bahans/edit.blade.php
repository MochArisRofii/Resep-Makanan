<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')
    <title>Edit Bahan</title>
    
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Masakan</a>
            <div class="space-x-4">
                <a href="{{ route('reseps.show', $bahan->resep_id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">Kembali ke Detail Resep</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 max-w-xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Edit Bahan</h1>

            <form action="{{ route('bahans.update', $bahan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label for="name" class="block text-lg font-medium text-gray-700">Nama Bahan:</label>
                    <input type="text" name="name" id="name" value="{{ $bahan->name }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="deskripsi" class="block text-lg font-medium text-gray-700">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $bahan->deskripsi }}</textarea>
                </div>

                <div class="space-y-2">
                    <label for="quantity" class="block text-lg font-medium text-gray-700">Jumlah:</label>
                    <input type="number" name="quantity" id="quantity" value="{{ (int) $bahan->quantity }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="unit" class="block text-lg font-medium text-gray-700">Satuan:</label>
                    <input type="text" name="unit" id="unit" value="{{ $bahan->unit }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="resep_id" class="block text-lg font-medium text-gray-700">Resep:</label>
                    <select name="resep_id" id="resep_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($reseps as $resep)
                            <option value="{{ $resep->id }}" {{ $bahan->resep_id == $resep->id ? 'selected' : '' }}>
                                {{ $resep->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition w-full">Update Bahan</button>
            </form>

        </div>
    </div>
</body>
</html>
