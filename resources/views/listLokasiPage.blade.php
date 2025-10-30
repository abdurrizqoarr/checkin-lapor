<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
        <h1 class="text-lg font-semibold">Daftar Lokasi</h1>
        <div class="flex gap-2">
            <a href="{{ route('lokasi.create') }}"
                class="bg-white text-blue-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition">
                + Tambah Data
            </a>
            <a href="{{ url()->previous() }}"
                class="bg-white text-blue-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-100 transition">
                ← Kembali
            </a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-6">

        <!-- Form Pencarian -->
        <form method="GET" class="mb-6 flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lokasi..."
                class="flex-grow sm:flex-none sm:w-1/3 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Cari
            </button>
        </form>

        <!-- Daftar Lokasi -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full border-collapse text-left">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">Nama Point</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lokasi as $index => $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                            <td class="px-6 py-3">{{ $item->nama_point }}</td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('lokasi.edit', $item->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm">
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('lokasi.delete', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus lokasi ini?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                        Delete
                                    </button>
                                </form>

                                <!-- Tombol Cetak QR -->
                                <a href="{{ route('point.generateQr', $item->id) }}"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">
                                    Cetak QR
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">
                                Tidak ada data lokasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (opsional jika pakai paginate di controller) -->
        {{-- @if (method_exists($lokasi, 'links'))
            <div class="mt-6">
                {{ $lokasi->links('pagination::tailwind') }}
            </div>
        @endif --}}
    </main>

    <footer class="bg-gray-200 text-center py-4 text-sm text-gray-600">
        &copy; {{ date('Y') }} Aplikasi QR Lokasi
    </footer>

</body>

</html>
