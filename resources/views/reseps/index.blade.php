<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Masakan</title>
    @vite('resources/css/app.css')
    <style>
        .typing-animation {
            white-space: nowrap;
            overflow: hidden;
            animation: typing steps(40, end), blink-caret .75s step-end infinite;
        }
        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
        @keyframes blink-caret {
            from,
            to {
                border-color: transparent;
            }

            50% {
                border-color: rgb(255, 255, 255);
            }
        }
        .dragging {
            opacity: 0.5;
            transform: rotate(5deg) scale(1.05);
        }

        .dropzone-hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Masakan</a>
            <div>
                <a href="{{ route('reseps.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 
                    transition ease-in-out duration-300">Tambah Resep Baru</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 id="judul-resep" class="text-4xl font-bold mb-8 text-center"></h1>

        <ul id="recipe-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($reseps as $resep)
                <li id="item-{{ $resep->id }}"
                    class="bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform hover:scale-105 draggable"
                    draggable="true" ondragstart="drag(event)" ondragend="dragEnd(event)">
                    @if ($resep->photo)
                        <a href="{{ route('reseps.show', $resep->id) }}">
                            <img src="{{ asset('storage/' . $resep->photo) }}" alt="{{ $resep->name }}"
                                class="w-full h-48 object-cover cursor-pointer transition-opacity duration-300 hover:opacity-75">
                        </a>
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <p class="text-lg font-semibold">{{ $resep->name }}</p>
                        <div class="mt-4 flex justify-between space-x-2">
                            <a href="{{ route('reseps.edit', $resep->id) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition">Ubah</a>
                            <form action="{{ route('reseps.destroy', $resep->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        const title = 'Daftar Resep Masakan';
        let i = 0;
        const speed = 100;

        function typeWriter() {
            if (i < title.length) {
                document.getElementById("judul-resep").innerHTML += title.charAt(i);
                i++;
                setTimeout(typeWriter, speed);
            } else {
                document.getElementById("judul-resep").classList.add("typing-animation");
            }
        }

        window.onload = typeWriter;

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
            ev.target.classList.add("dragging");
        }

        function dragEnd(ev) {
            ev.target.classList.remove("dragging");
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drop(ev) {
            ev.preventDefault();
            const data = ev.dataTransfer.getData("text");
            const draggedElement = document.getElementById(data);
            const target = ev.target.closest("li");

            if (target && draggedElement !== target) {
                target.parentNode.insertBefore(draggedElement, target.nextSibling);
            }
        }

        document.getElementById('recipe-list').addEventListener('dragover', allowDrop);
        document.getElementById('recipe-list').addEventListener('drop', drop);

        // Adding dropzone hover effect
        document.getElementById('recipe-list').addEventListener('dragenter', function (ev) {
            const target = ev.target.closest("li");
            if (target) {
                target.classList.add("dropzone-hover");
            }
        });

        document.getElementById('recipe-list').addEventListener('dragleave', function (ev) {
            const target = ev.target.closest("li");
            if (target) {
                target.classList.remove("dropzone-hover");
            }
        });
    </script>
</body>

</html>
