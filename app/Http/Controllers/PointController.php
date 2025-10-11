<?php

namespace App\Http\Controllers;

use App\Models\CheckinLogs;
use App\Models\PointQr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PointController extends Controller
{
    public function checkinPage($id)
    {
        $detailPoint = PointQr::find($id);

        return view('checkinPage', ['detailPoint' => $detailPoint]);
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
            // Respons jika validasi gagal
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Respons jika error tidak terduga
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
