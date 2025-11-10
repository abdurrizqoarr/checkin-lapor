<?php

namespace App\Http\Controllers;

use App\Exports\CheckinLogsExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportLogsControllers extends Controller
{
    public function getHariIndonesia($date = null)
    {
        // Gunakan tanggal saat ini jika tidak diberikan
        $carbon = $date ? Carbon::parse($date) : Carbon::now();

        // Ambil nama hari dalam bahasa Inggris
        $dayName = $carbon->format('l'); // Contoh: Monday, Tuesday, dll

        // Ubah ke Bahasa Indonesia
        $hariIndonesia = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $hariIndonesia[$dayName] ?? $dayName;
    }

    public function exportPage()
    {
        $hariIndo = $this->getHariIndonesia();
        $dataUser = Auth::guard('admin')->user();

        return view('exportCheckpointPage', [
            'dataUser' => $dataUser,
            'hariIndo' => $hariIndo,
        ]);
    }

    public function handleExport(Request $request)
    {
         // Validasi input tanggal
        $validated = $request->validate([
            'tanggalAwal' => 'required|date',
            'tanggalAkhir' => 'required|date|after_or_equal:tanggalAwal',
        ], [
            'tanggalAwal.required' => 'Tanggal awal wajib diisi.',
            'tanggalAkhir.required' => 'Tanggal akhir wajib diisi.',
            'tanggalAkhir.after_or_equal' => 'Tanggal akhir harus setelah tanggal awal.',
        ]);

        // Ambil data tanggal dari request
        $start = Carbon::parse($validated['tanggalAwal'])->startOfDay();
        $end   = Carbon::parse($validated['tanggalAkhir'])->endOfDay();

        // Kirim parameter tanggal ke Export class
        return Excel::download(new CheckinLogsExport($start, $end), 'checkin_logs_' . now()->format('Ymd_His') . '.xlsx');
    }
}
