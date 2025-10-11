<?php

namespace App\Http\Controllers;

use App\Models\PointQr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeContoller extends Controller
{
    public function loginPage()
    {
        return view('loginPage');
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    function getHariIndonesia($date = null)
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

    public function dashboard()
    {
        $hariIndo = $this->getHariIndonesia();
        $dataUser = Auth::user();
        $jadwalUser = $dataUser->jadwalUsers()
            ->with('jadwal')
            ->get()
            ->sortBy(function ($item) {
                $urutan = [
                    'Senin' => 1,
                    'Selasa' => 2,
                    'Rabu' => 3,
                    'Kamis' => 4,
                    'Jumat' => 5,
                    'Sabtu' => 6,
                    'Minggu' => 7,
                ];

                return $urutan[$item->jadwal->hari] ?? 8; // default di akhir jika tidak cocok
            })
            ->values();
        $riwayatsCheckinHariIni = $dataUser->checkinLogs()
            ->whereDate('waktu_checkin', now()->toDateString())
            ->with('pointQr') // eager load relasi point_qr
            ->get();
        $seluruhRutinitas = PointQr::get();

        return view('dashboardPage', [
            'dataUser' => $dataUser,
            'jadwalUser' => $jadwalUser,
            'riwayatsCheckinHariIni' => $riwayatsCheckinHariIni,
            'seluruhRutinitas' => $seluruhRutinitas,
            'hariIndo' => $hariIndo,
        ]);
    }
}
