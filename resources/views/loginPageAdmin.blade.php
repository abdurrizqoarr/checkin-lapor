<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-sky-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6 sm:p-8 text-base sm:text-lg">
        <div class="text-center pb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-sky-700">Selamat Datang</h1>
            <p class="text-sky-500 mt-1">Masuk untuk melanjutkan ke beranda</p>
        </div>

        <form method="POST">
            @csrf

            <div class="pb-5 mb-4">
                <label for="username" class="block text-sky-700 font-medium mb-1">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" value="{{ old('username') }}"
                    class="w-full px-4 py-3 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                    placeholder="Masukkan username" required>

                {{-- Pesan error untuk username --}}
                @error('username')
                    <p class="mt-1 text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pb-5">
                <label for="password" class="block text-sky-700 font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" autocomplete="off"
                    class="w-full px-4 py-3 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                    placeholder="Masukkan password" required>
            </div>

            <button id="btnSubmit" type="submit"
                class="w-full py-3 mt-4 bg-sky-600 hover:bg-sky-700 transition-colors text-white font-semibold rounded-xl shadow-md active:scale-[0.98]">
                Masuk
            </button>
        </form>
    </div>
</body>

</html>
