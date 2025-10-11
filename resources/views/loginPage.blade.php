<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-sky-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg p-6 mx-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-sky-700">Selamat Datang</h1>
            <p class="text-sky-500 text-sm mt-1">Masuk untuk melanjutkan ke beranda</p>
        </div>

        <form method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="username" class="block text-sky-700 text-sm font-medium mb-1">Username</label>
                <input type="text" name="username" id="username" autocomplete="off"
                    class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                    placeholder="Masukkan username" required>
            </div>

            <div>
                <label for="password" class="block text-sky-700 text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" autocomplete="new-password"
                    class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                    placeholder="Masukkan password" required>
            </div>

            <button id="btnSubmit" type="submit"
                class="w-full py-2 mt-2 bg-sky-600 hover:bg-sky-700 transition-colors text-white font-semibold rounded-xl shadow-md active:scale-[0.98]">
                Masuk
            </button>
        </form>
    </div>
</body>

</html>
