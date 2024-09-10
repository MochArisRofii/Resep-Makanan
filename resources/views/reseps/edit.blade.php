<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')
    
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Masakan</a>
            <div class="space-x-4">
                <a href="{{ route('reseps.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">Kembali ke Menu Resep</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-center">Edit Resep</h1>

        <form action="{{ route('reseps.update', $resep->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Nama Resep:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $resep->name) }}" class="w-full mt-1 border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('name')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-semibold">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" class="w-full mt-1 border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >{{ old('deskripsi', $resep->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="photo" class="block text-gray-700 font-semibold">Foto Resep Saat Ini:</label>
                @if($resep->photo)
                    <img src="{{ asset('storage/' . $resep->photo) }}" alt="Foto Resep" class="mt-2 mb-4 w-full max-w-xs h-auto object-cover rounded-md shadow-md mx-auto">
                @endif
                <label for="photo" class="block text-gray-700 font-semibold mt-2">Ubah Foto Resep:</label>
                <input type="file" id="photo" name="photo" class="w-full mt-1 border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
                @error('photo')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg shadow hover:bg-blue-600 transition">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>
