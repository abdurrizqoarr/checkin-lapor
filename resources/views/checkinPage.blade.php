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
            <div class="text-center mb-10">
                <h1 class="text-3xl font-semibold text-sky-800">Lapor Patroli</h1>
                <p class="text-sky-600 mt-1">{{ $detailPoint['nama_point'] }}</p>
            </div>

            <!-- Form -->
            <form id="checkinForm" autocomplete="off" class="space-y-5">
                @csrf

                <input type="hidden" name="point_qr_id" id="point_qr_id" value="{{ $detailPoint['id'] }}">
                <input type="hidden" name="photo" id="photo">

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sky-700 font-medium mb-1">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off"
                        class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                        placeholder="Masukkan username" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sky-700 font-medium mb-1">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off"
                        class="w-full px-4 py-2 rounded-xl border border-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400 text-gray-700 placeholder-sky-300"
                        placeholder="Masukkan password" required>
                </div>

                <!-- Kamera -->
                <div>
                    <label class="block text-sky-700 font-medium mb-2">Ambil Foto</label>
                    <div class="flex flex-col items-center space-y-3">
                        <video id="cameraStream" autoplay playsinline
                            class="rounded-lg border border-sky-300 w-full h-80 object-cover"></video>
                        <canvas id="snapshotCanvas" class="hidden"></canvas>
                        <button type="button" id="btnCapture"
                            class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                            Ambil Foto
                        </button>
                        <img id="previewImage" class="hidden rounded-lg w-full border border-sky-300" alt="Preview Foto">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                    class="w-full py-2 mt-4 bg-sky-400 text-white font-semibold rounded-xl shadow-md active:scale-[0.98] cursor-not-allowed"
                    id="btnSubmit" disabled>
                    Masuk
                </button>
            </form>

            <!-- Notifikasi -->
            <div id="responseMessage" class="mt-4 text-center text-red-500 font-medium"></div>
        </div>
    </div>

    @vite(['resources/js/checkin.js'])
</body>

</html>
