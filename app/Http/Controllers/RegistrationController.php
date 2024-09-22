<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function index()
    {
        return view('register.index');
    }

    function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $fullName = $request->input('name');

        $error = "";

        try {
            $insertUser = new User;

            $insertUser->email = $email;
            $insertUser->password = Hash::make($password);
            $insertUser->nama = $fullName;
            $insertUser->is_active = true;

            $insertUser->save();
            
        } catch (\Exception $e) {
            switch ($e->errorInfo[1]) {
                case 1062:
                    $error = "Registrasi Gagal! User sudah terdaftar";
                    break;

                default:
                    $error = "backend error ".$e->errorInfo[1];
                    break;
            }
        }

        if ($error !== "") {
            $response = [
                'type' => 'error',
                'message' => $error
            ];
        } else {
            $response = [
                'type' => 'success',
                'message' => 'Registrasi Berhasil!'
            ];
        }

        return response()->json($response);
    }
}
