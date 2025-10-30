<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Script animasi tanggal dan jam
        document.addEventListener('DOMContentLoaded', () => {
            const waktuEl = document.getElementById('waktu');
            const updateWaktu = () => {
                const now = new Date();
                const tanggal = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                const jam = now.toLocaleTimeString('id-ID');
                waktuEl.innerHTML = `${tanggal} | ${jam}`;
            };
            updateWaktu();
            setInterval(updateWaktu, 1000);
        });
    </script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen font-sans text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="flex items-center gap-6">
            <h1 class="text-xl font-semibold text-gray-700">Admin Dashboard</h1>
            <a href="{{ route('lokasi.page') }}" class="text-gray-600 hover:text-blue-500 transition">Lokasi QR</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition">Pegawai</a>
            <a href="#" class="text-gray-600 hover:text-blue-500 transition">Jadwal Jaga</a>
        </div>
        <div class="flex items-center gap-4">
            <p class="text-gray-700 font-medium">{{ $user->name }}</p>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Konten utama -->
    <main class="flex flex-col items-center justify-center mt-20 text-center px-4">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Selamat Datang, {{ $user->name }}!</h2>
        <p id="waktu" class="text-lg text-gray-600 animate-pulse"></p>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-4xl">
            <a href="{{ route('lokasi.page') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-gray-700 mb-2">Kelola Lokasi QR</h3>
                <p class="text-sm text-gray-500">Atur dan pantau titik lokasi untuk scan QR.</p>
            </a>
            <a class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-gray-700 mb-2">Kelola Pegawai</h3>
                <p class="text-sm text-gray-500">Tambahkan, ubah, atau hapus data pegawai.</p>
            </a>
            <address class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="font-semibold text-gray-700 mb-2">Jadwal Jaga</h3>
                <p class="text-sm text-gray-500">Lihat dan ubah jadwal shift pegawai.</p>
                </diav>
        </div>
    </main>
</body>

</html>
