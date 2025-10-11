<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gradient-to-b from-sky-50 to-white text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-md mx-auto py-4 px-5 flex flex-col gap-1 text-center">
                <p class="text-sm text-gray-500">{{ $hariIndo }}, {{ now()->format('d F Y') }}</p>
                <p class="text-base mt-1 font-medium text-gray-700">
                    Halo, <span class="text-sky-600 font-semibold">{{ $dataUser->name }}</span> 👋
                </p>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 w-full max-w-md mx-auto px-4 py-6">
            <div x-data="{ tab: 'riwayat' }" class="space-y-6">
                <!-- Tabs -->
                <div class="flex justify-center bg-white rounded-full p-1 shadow-sm">
                    <button class="flex-1 text-sm font-medium py-2 rounded-full transition-all"
                        :class="tab === 'riwayat'
                            ? 'bg-sky-600 text-white shadow'
                            : 'text-gray-500 hover:bg-sky-100'"
                        @click="tab = 'riwayat'">
                        Riwayat
                    </button>
                    <button class="flex-1 text-sm font-medium py-2 rounded-full transition-all"
                        :class="tab === 'jadwal'
                            ? 'bg-sky-600 text-white shadow'
                            : 'text-gray-500 hover:bg-sky-100'"
                        @click="tab = 'jadwal'">
                        Jadwal
                    </button>
                </div>

                <!-- Tab Riwayat -->
                <div x-show="tab === 'riwayat'" x-transition.opacity.duration.300ms>
                    <!-- Riwayat Hari Ini -->
                    <div class="bg-white rounded-2xl shadow-sm p-5 mb-5">
                        <h2 class="text-base font-semibold text-sky-700 mb-3">Riwayat Check-in Hari Ini</h2>

                        @if ($riwayatsCheckinHariIni->isEmpty())
                            <p class="text-gray-500 text-sm">Belum ada check-in hari ini.</p>
                        @else
                            <div class="space-y-3">
                                @foreach ($riwayatsCheckinHariIni as $log)
                                    <div
                                        class="flex justify-between items-center bg-sky-50 border border-sky-100 rounded-xl px-4 py-2">
                                        <div>
                                            <p class="text-gray-700 font-medium">
                                                {{ $log->pointQr->nama_point ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($log->waktu_checkin)->format('H:i') }}
                                            </p>
                                        </div>
                                        <div
                                            class="bg-sky-100 text-sky-700 text-xs px-3 py-1 rounded-full font-semibold">
                                            Selesai
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Lokasi Belum Dikunjungi -->
                    <div class="bg-white rounded-2xl shadow-sm p-5">
                        <h2 class="text-base font-semibold text-sky-700 mb-3">Lokasi yang Belum Dikunjungi</h2>

                        @php
                            $visited = $riwayatsCheckinHariIni->pluck('point_qr_id')->toArray();
                            $unvisited = $seluruhRutinitas->whereNotIn('id', $visited);
                        @endphp

                        @if ($unvisited->isEmpty())
                            <p class="text-green-600 font-medium text-sm">Semua lokasi telah dikunjungi hari ini ✅</p>
                        @else
                            <ul class="divide-y divide-gray-100">
                                @foreach ($unvisited as $point)
                                    <li class="py-2 text-sm text-gray-700">{{ $point->nama_point }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Tab Jadwal -->
                <div x-show="tab === 'jadwal'" x-transition.opacity.duration.300ms>
                    <div class="bg-white rounded-2xl shadow-sm p-5">
                        <h2 class="text-base font-semibold text-sky-700 mb-3">Jadwal User</h2>

                        @if ($jadwalUser->isNotEmpty())
                            <ul class="space-y-2">
                                @foreach ($jadwalUser as $jadwal)
                                    <li
                                        class="bg-sky-50 border border-sky-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium">
                                        {{ ucfirst($jadwal->hari) }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">Belum ada jadwal yang terdaftar.</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
