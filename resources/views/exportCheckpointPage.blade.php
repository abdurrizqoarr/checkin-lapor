<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Export Catatan Check-in Pegawai</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gradient-to-b from-sky-50 to-white text-gray-800">
    <div class="min-h-screen flex flex-col gap-16 sm:gap-24">

        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-4xl mx-auto py-4 px-4 sm:px-5 flex flex-col gap-1 text-center">
                <p class="text-sm sm:text-base text-gray-500">{{ $hariIndo }}, {{ now()->format('d F Y') }}</p>
                <p class="text-2xl sm:text-4xl mt-1 font-medium text-gray-700">
                    Halo, <span class="text-sky-600 font-semibold">{{ $dataUser->name }}</span> 👋
                </p>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 w-full mx-auto px-4 sm:px-12 py-6 text-base sm:text-lg">
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-sky-50 p-6 sm:p-10">
                <h1 class="text-2xl sm:text-3xl font-semibold text-sky-700 text-center mb-6">
                    Export Catatan Check-in Pegawai
                </h1>

                <p class="text-gray-500 text-center mb-8">
                    Pilih rentang tanggal untuk mengekspor data check-in pegawai ke dalam file Excel.
                </p>

                <form method="POST" class="space-y-6">
                    @csrf

                    <!-- Input tanggal -->
                    <div class="flex flex-col sm:flex-row gap-6 sm:gap-4 justify-center">
                        <div class="flex flex-col w-full sm:w-1/2">
                            <label for="tanggalAwal" class="text-gray-600 font-medium mb-1">Tanggal Awal</label>
                            <input type="date" name="tanggalAwal" id="tanggalAwal"
                                class="px-4 py-2 border border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-gray-700 transition">
                        </div>

                        <div class="flex flex-col w-full sm:w-1/2">
                            <label for="tanggalAkhir" class="text-gray-600 font-medium mb-1">Tanggal Akhir</label>
                            <input type="date" name="tanggalAkhir" id="tanggalAkhir"
                                class="px-4 py-2 border border-sky-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-gray-700 transition">
                        </div>
                    </div>

                    <!-- Tombol Export -->
                    <div class="flex justify-center pt-4">
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-full px-8 py-3 shadow-sm transition transform hover:scale-105">
                            📄 Export ke Excel
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
