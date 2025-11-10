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

<body class="antialiased bg-gradient-to-b from-sky-50 to-white text-gray-800">
    <div class="min-h-screen flex flex-col gap-16 sm:gap-24">
        <!-- Header / Navbar -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div
                class="max-w-5xl mx-auto py-4 px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-semibold text-sky-700">Admin Dashboard</h1>

                <nav class="flex items-center gap-4 sm:gap-6 text-sm sm:text-base">
                    <a href="{{ route('lokasi.page') }}"
                        class="text-gray-600 hover:text-sky-600 transition font-medium">Lokasi QR</a>
                    <a href="#" class="text-gray-600 hover:text-sky-600 transition font-medium">Pegawai</a>
                    <a href="#" class="text-gray-600 hover:text-sky-600 transition font-medium">Jadwal Jaga</a>
                </nav>

                <div class="flex items-center gap-3">
                    <p class="text-gray-700 font-medium hidden sm:block">{{ $user->name }}</p>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-full text-sm font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Konten utama -->
        <main class="flex-1 w-full mx-auto px-4 sm:px-8 py-6 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl sm:text-4xl font-semibold text-gray-700 mb-2">
                    Selamat Datang, <span class="text-sky-600">{{ $user->name }}</span> 👋
                </h2>
                <p id="waktu" class="text-gray-500 text-sm sm:text-base animate-pulse mb-10"></p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kartu 1 -->
                    <a href="{{ route('lokasi.page') }}"
                        class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-md transition text-left border border-sky-50">
                        <h3 class="text-xl sm:text-2xl font-semibold text-sky-700 mb-2">Kelola Lokasi QR</h3>
                        <p class="text-gray-500 text-sm sm:text-base">Atur dan pantau titik lokasi untuk scan QR.</p>
                    </a>

                    <!-- Kartu 2 -->
                    <a href="#"
                        class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-md transition text-left border border-sky-50">
                        <h3 class="text-xl sm:text-2xl font-semibold text-sky-700 mb-2">Kelola Pegawai</h3>
                        <p class="text-gray-500 text-sm sm:text-base">Tambahkan, ubah, atau hapus data pegawai.</p>
                    </a>

                    <!-- Kartu 3 -->
                    <a href="#"
                        class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-md transition text-left border border-sky-50">
                        <h3 class="text-xl sm:text-2xl font-semibold text-sky-700 mb-2">Jadwal Jaga</h3>
                        <p class="text-gray-500 text-sm sm:text-base">Lihat dan ubah jadwal shift pegawai.</p>
                    </a>
                    <!-- Kartu 3 -->
                    <a href="{{ route('export-logs') }}"
                        class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-md transition text-left border border-sky-50">
                        <h3 class="text-xl sm:text-2xl font-semibold text-sky-700 mb-2">Export Data</h3>
                        <p class="text-gray-500 text-sm sm:text-base">Export laporan checkin ke excel.</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
