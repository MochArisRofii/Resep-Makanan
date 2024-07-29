<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>Detail Resep</title>
    <style>
        .draggable {
            cursor: move;
            padding: 8px;
            margin-bottom: 4px;
            border-radius: 8px;
            /* Menambahkan radius untuk sudut elemen */
            background-color: #ffffff;
            /* Warna latar belakang putih untuk elemen */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Tambahkan bayangan halus */
            transition: all 0.3s ease;
            /* Transisi halus untuk efek visual */
        }

        .draggable.dragging {
            opacity: 0.5;
            /* Gaya saat di-drag */
            transform: scale(1.05);
            /* Sedikit perbesaran saat di-drag */
        }

        .drag-over {
            background-color: rgba(0, 0, 255, 0.1);
            /* Highlight area drop */
            box-shadow: 0 4px 8px rgba(0, 0, 255, 0.3);
            /* Tambahkan bayangan */
            transition: all 0.3s ease;
            /* Transisi halus untuk efek visual */
        }

        ul {
            list-style-type: none;
            /* Hapus bullet points */
            padding: 0;
            /* Hapus padding default */
            margin: 0;
            /* Hapus margin default */
        }

        li {
            transition: all 0.3s ease;
            /* Transisi halus untuk perubahan */
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Masakan</a>
            <div class="space-x-4">
                <a href="{{ route('bahans.create', $resep->id) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition">Tambah
                    Bahan</a>
                <a href="{{ route('reseps.index') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">Kembali ke
                    Daftar Resep</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-4xl font-bold mb-4 text-center">{{ $resep->name }}</h1>
            <p class="text-lg text-gray-600 mb-8">{{ $resep->deskripsi }}</p>

            <h2 class="text-2xl font-semibold mb-4">Daftar Bahan</h2>
            <ul id="bahan-list">
                @foreach ($bahans as $bahan)
                    <li id="item-{{ $bahan->id }}" class="draggable py-4 flex justify-between items-center"
                        draggable="true" ondragstart="drag(event)" ondragend="dragEnd(event)">
                        <div>
                            <span class="text-lg font-medium">{{ $bahan->name }}</span> - {{ (int) $bahan->quantity }}
                            {{ $bahan->unit }}
                            <p class="text-sm text-gray-500">{{ $bahan->deskripsi }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('bahans.edit', $bahan->id) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded-md shadow hover:bg-yellow-500 transition">Ubah</a>
                            <form action="{{ route('bahans.destroy', $bahan->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-md shadow hover:bg-red-600 transition"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus bahan ini?')">Hapus</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
            ev.target.classList.add('dragging'); // Tambahkan kelas 'dragging' saat elemen di-drag
        }

        function dragEnd(ev) {
            ev.target.classList.remove('dragging'); // Hapus kelas 'dragging' setelah elemen di-drop
        }

        function allowDrop(ev) {
            ev.preventDefault();
            if (ev.target && ev.target.closest("li")) {
                ev.target.closest("li").classList.add("drag-over");
            }
        }

        function drop(ev) {
            ev.preventDefault();
            const data = ev.dataTransfer.getData("text");
            const draggedElement = document.getElementById(data);
            const target = ev.target.closest("li");

            if (target && draggedElement !== target) {
                target.classList.remove("drag-over");

                // Menentukan posisi baru untuk elemen yang di-drag
                if (target.nextSibling) {
                    target.parentNode.insertBefore(draggedElement, target.nextSibling);
                } else {
                    target.parentNode.appendChild(draggedElement);
                }

                // Update server-side position
                updatePositions();
            }
        }

        function clearDragOverClass(ev) {
            if (ev.target && ev.target.closest("li")) {
                ev.target.closest("li").classList.remove("drag-over");
            }
        }

        function updatePositions() {
            const items = document.querySelectorAll('#bahan-list .draggable');
            const positions = Array.from(items).map(item => item.id.replace('item-', ''));

            fetch('{{ route('bahans.updatePosition') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        positions: positions
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Positions updated successfully');
                    } else {
                        console.error('Error updating positions:', data.message);
                    }
                })
                .catch(error => console.error('Error updating positions:', error));
        }

        const list = document.getElementById('bahan-list');
        list.addEventListener('dragover', allowDrop);
        list.addEventListener('drop', drop);
        list.addEventListener('dragleave', clearDragOverClass);
    </script>
</body>

</html>
