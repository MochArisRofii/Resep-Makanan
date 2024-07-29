<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Daftar Resep Masakan</h1>

        <a href="{{ route('reseps.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">Tambah Resep Baru</a>
        
        <ul class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($reseps as $resep)
                <li class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($resep->photo)
                        <img src="{{ asset('storage/' . $resep->photo) }}" alt="{{ $resep->name }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <a href="{{ route('reseps.show', $resep->id) }}" class="text-lg font-semibold hover:underline">{{ $resep->name }}</a>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('reseps.edit', $resep->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded shadow hover:bg-yellow-600 transition">Ubah</a>
                            <form action="{{ route('reseps.destroy', $resep->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>

</html>
