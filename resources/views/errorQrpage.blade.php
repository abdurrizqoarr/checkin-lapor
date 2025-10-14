<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $point->nama_point }} - QR Check-in</title>
    @vite(['resources/css/app.css'])

    <style>
        /* Gaya cetak minimalis */
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md text-center border-2 border-gray-300 rounded-xl p-6 shadow-lg">
        <!-- Judul -->
        <h1 class="text-2xl font-bold mb-1 uppercase tracking-wide">
            {{ $point->nama_point }}
        </h1>
    </div>

</body>

</html>
