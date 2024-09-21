<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        try {
            $insertUser = new User;

            $insertUser->email = $email;
            $insertUser->password = $password;
            $insertUser->nama = $fullName;
            $insertUser->is_active = true;

            $result = $insertUser->save();
        } catch (\Exception $e) {
            switch ($e->errorInfo[1]) {
                case 1062:
                    $error = "Registrasi Gagal! User sudah terdaftar";
                    break;

                default:
                    $error = "backend error";
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
