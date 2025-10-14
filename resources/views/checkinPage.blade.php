<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Point</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-sky-50 to-sky-200">

    <div class="w-full max-w-md mx-auto p-6">
        <!-- Kartu Utama -->
        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-2xl p-6 border border-sky-100">
            <!-- Nama Point -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-semibold text-sky-800">Lapor Patroli</h1>
                <p class="text-sky-600 mt-1">{{ $detailPoint['nama_point'] }}</p>
            </div>

            <!-- Form -->
            <form id="checkinForm" autocomplete="off" class="space-y-5">
                @csrf

                <input type="hidden" name="point_qr_id" id="point_qr_id" value="{{ $detailPoint['id'] }}">

                <div class="mb-6">
                    <label for="username" class="block text-sky-700 font-medium mb-1">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off"
                        class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                        placeholder="Masukkan username" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sky-700 font-medium mb-1">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off"
                        class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                        placeholder="Masukkan password" required>
                </div>

                <button type="submit"
                    class="w-full py-2 mb-8 mt-2 bg-sky-600 hover:bg-sky-700 transition-colors text-white font-semibold rounded-xl shadow-md active:scale-[0.98]"
                    id="btnSubmit">
                    Masuk
                </button>
            </form>

            <!-- Notifikasi -->
            <div id="responseMessage" class="mt-4 text-center"></div>
        </div>
    </div>
    @vite(['resources/js/checkin.js'])

</body>

</html>
