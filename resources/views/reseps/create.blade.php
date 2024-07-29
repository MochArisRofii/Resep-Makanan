<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')
    
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-center">Tambah Resep Baru</h1>

        <!-- Formulir untuk menambah resep baru -->
        <form action="{{ route('reseps.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf <!-- Token CSRF untuk keamanan -->

            <div class="form-group mb-4">
                <label for="name" class="block text-gray-700">Nama Resep:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="deskripsi" class="block text-gray-700">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" class="w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="photo" class="block text-gray-700">Foto Resep:</label>
                <input type="file" id="photo" name="photo" class="w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('photo')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg shadow hover:bg-blue-600 transition">Simpan</button>
        </form>

        <a href="{{ route('home') }}" class="block text-center text-blue-500 mt-4 hover:underline">Kembali ke Halaman Utama</a>
    </div>
</body>

</html>
