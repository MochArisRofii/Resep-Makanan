<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full p-3 mt-2 border border-gray-300 rounded-lg" required>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
