<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')
    <title>Detail Resep</title>
    
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Masakan</a>
            <div class="space-x-4">
                <a href="{{ route('bahans.create', $resep->id) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition">Tambah Bahan</a>
                <a href="{{ route('reseps.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">Kembali ke Daftar Resep</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-4xl font-bold mb-4 text-center">{{ $resep->name }}</h1>
            <p class="text-lg text-gray-600 mb-8">{{ $resep->deskripsi }}</p>

            <h2 class="text-2xl font-semibold mb-4">Daftar Bahan</h2>
            <ul class="divide-y divide-gray-200">
                @foreach ($bahans as $bahan)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <span class="text-lg font-medium">{{ $bahan->name }}</span> - {{ (int) $bahan->quantity }} {{ $bahan->unit }}
                            <p class="text-sm text-gray-500">{{ $bahan->deskripsi }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('bahans.edit', $bahan->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded-md shadow hover:bg-yellow-500 transition">Ubah</a>
                            <form action="{{ route('bahans.destroy', $bahan->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md shadow hover:bg-red-600 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus bahan ini?')">Hapus</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html>
