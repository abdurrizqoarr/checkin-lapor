<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi</title>
    @vite(['resources/css/app.css'])
</head>

<body class="antialiased bg-gradient-to-b from-sky-50 to-white text-gray-800">
    <div class="min-h-screen flex flex-col gap-16 sm:gap-20">

        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div
                class="max-w-5xl mx-auto py-4 px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-semibold text-sky-700">Daftar Lokasi</h1>
                <div class="flex gap-2">
                    <a href="{{ route('lokasi.create') }}"
                        class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-full text-sm sm:text-base font-medium shadow-sm transition">
                        + Tambah Data
                    </a>
                    <a href="{{ url()->previous() }}"
                        class="bg-white hover:bg-sky-50 text-sky-700 border border-sky-100 px-4 py-2 rounded-full text-sm sm:text-base font-medium shadow-sm transition">
                        ← Kembali
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 w-full mx-auto px-4 sm:px-8 py-6">
            <div class="max-w-5xl mx-auto space-y-8">

                <!-- Form Pencarian -->
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lokasi..."
                        class="flex-grow sm:flex-none sm:w-1/3 px-4 py-2 border border-sky-200 rounded-full focus:ring-2 focus:ring-sky-500 focus:outline-none text-sm sm:text-base">
                    <button type="submit"
                        class="bg-sky-600 text-white px-5 py-2 rounded-full hover:bg-sky-700 text-sm sm:text-base font-medium transition">
                        Cari
                    </button>
                </form>

                <!-- Tabel Daftar Lokasi -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-sky-50">
                    <table class="w-full text-left text-sm sm:text-base">
                        <thead class="bg-sky-600 text-white">
                            <tr>
                                <th class="px-6 py-3 font-semibold">#</th>
                                <th class="px-6 py-3 font-semibold">Nama Point</th>
                                <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lokasi as $index => $item)
                                <tr class="border-b border-sky-50 hover:bg-sky-50 transition">
                                    <td class="px-6 py-3">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-gray-700 font-medium">{{ $item->nama_point }}</td>
                                    <td class="px-6 py-3 text-center space-x-2">

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('lokasi.edit', $item->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold shadow-sm transition">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('lokasi.delete', $item->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus lokasi ini?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold shadow-sm transition">
                                                Hapus
                                            </button>
                                        </form>

                                        <!-- Tombol Cetak QR -->
                                        <a href="{{ route('point.generateQr', $item->id) }}"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-full text-xs sm:text-sm font-semibold shadow-sm transition">
                                            Cetak QR
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6 text-gray-500 font-medium">
                                        Tidak ada data lokasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (jika pakai paginate di controller) -->
                {{-- @if (method_exists($lokasi, 'links'))
                    <div class="mt-6">
                        {{ $lokasi->links('pagination::tailwind') }}
                    </div>
                @endif --}}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-sky-100 text-center py-4 text-sm text-gray-500">
            &copy; {{ date('Y') }} Aplikasi QR Lokasi — Semua Hak Dilindungi
        </footer>
    </div>
</body>

</html>
