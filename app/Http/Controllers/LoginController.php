<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('login.index');
    }

    function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Login Gagal! Akun tidak ditemukan');
        }

        if (Auth::attemptWhen($credentials, function ($user) {
            return ($user->is_active == 1);
        })) {
            $request->session()->regenerate();
            return to_route('home');
        } else {
            if ($user->is_active == 0){
                return back()->with('error', 'Login Gagal! Akun Tidak Aktif');
            }else{
                return back()->with('error', 'Login Gagal! Password salah');
            }            
        }
    }
}
