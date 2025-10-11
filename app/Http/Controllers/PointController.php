<?php

namespace App\Http\Controllers;

use App\Models\CheckinLogs;
use App\Models\JadwalUser;
use App\Models\PointQr;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PointController extends Controller
{
    public function checkinPage($id)
    {
        $detailPoint = PointQr::find($id);

        return view('checkinPage', ['detailPoint' => $detailPoint]);
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

    public function checkin(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'point_qr_id' => 'required|exists:point_qr,id',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            // Cek user berdasarkan username
            $user = User::where('username', $validated['username'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Username atau password salah.',
                ], 401);
            }

            if (! JadwalUser::where('user_id', $user->id)
                ->where('hari', $this->getHariIndonesia())
                ->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hari ini bukan jadwal jaga.',
                ], 400);
            }

            // Cek apakah user sudah check-in hari ini di lokasi yang sama
            $riwayatCheckin = CheckinLogs::where('user_id', $user->id)
                ->where('point_qr_id', $validated['point_qr_id'])
                ->whereDate('waktu_checkin', now()->toDateString())
                ->first();

            if ($riwayatCheckin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi ini sudah dikunjungi hari ini.',
                ], 400);
            }

            // Simpan data checkin
            $checkin = CheckinLogs::create([
                'user_id' => $user->id,
                'point_qr_id' => $validated['point_qr_id'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'foto' => null,
                'waktu_checkin' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil dilakukan!',
                'data' => [
                    'checkin_id' => $checkin->id,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                    ],
                    'point_qr_id' => $checkin->point_qr_id,
                    'latitude' => $checkin->latitude,
                    'longitude' => $checkin->longitude,
                    'waktu_checkin' => $checkin->waktu_checkin,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
