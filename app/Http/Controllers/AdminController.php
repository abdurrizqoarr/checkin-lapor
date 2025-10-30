<?php

namespace App\Http\Controllers;

use App\Models\PointQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function addLokasi(){
        return 0;
    }

    public function editLokasi(){
        return 0;
    }

    public function deleteLokasi(){
        return 0;
    }
}
