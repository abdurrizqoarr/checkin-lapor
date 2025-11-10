<?php

namespace App\Http\Controllers;

use App\Models\PointQr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function loginPageAdmin()
    {
        return view('loginPageAdmin');
    }

    public function handleLoginPageAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard-admin');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    public function dashboardAdmin()
    {
        $user = Auth::guard('admin')->user();

        return view('dashboardAdminPage', ['user' => $user]);
    }

    public function lokasiQR(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $lokasi = PointQr::where('nama_point', 'like', '%'.$search.'%')
                ->get();
        } else {
            $lokasi = PointQr::all();
        }

        return view('listLokasiPage', ['lokasi' => $lokasi]);
    }

    public function addLokasi(Request $request)
    {
        $validated = $request->validate([
            'nama_point' => 'required|string|max:255',
        ]);

        try {
            $lokasi = PointQr::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasil ditambahkan',
                'data' => $lokasi,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lokasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Edit lokasi
    public function editLokasi(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_point' => 'required|string|max:255',
        ]);

        $lokasi = PointQr::find($id);

        if (! $lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan',
            ], 404);
        }

        $lokasi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil diperbarui',
            'data' => $lokasi,
        ]);
    }

    // Hapus lokasi
    public function deleteLokasi($id)
    {
        $lokasi = PointQr::find($id);

        if (! $lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan',
            ], 404);
        }

        $lokasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil dihapus',
        ]);
    }

    public function addUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        // Enkripsi password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    // 🟡 List semua user (dengan opsi pencarian & pagination)
    public function listUser(Request $request)
    {
        $query = User::query();

        // Jika ada keyword pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        }

        // Pagination opsional
        $users = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    // 🔵 Edit user
    public function editUser(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,'.$request->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::find($validated['id']);

        // Jika password diisi, hash ulang
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'data' => $user,
        ]);
    }
}
