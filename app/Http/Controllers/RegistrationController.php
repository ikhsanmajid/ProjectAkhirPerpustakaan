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
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $jenisIdentitas = $request->input('jenis_identitas');
        $noIdentitas = $request->input('nomor_identitas');
        $noHp = $request->input('no_hp');
        $alamat = $request->input('alamat');
        $email = $request->input('email');
        $password = $request->input('password');

        $error = "";

        try {
            $insertUser = new User;

            $insertUser->email = $email;
            $insertUser->password = Hash::make($password);
            $insertUser->first_name = $firstName;
            $insertUser->last_name = $lastName;
            $insertUser->jenis_identitas = $jenisIdentitas;
            $insertUser->nomor_identitas = $noIdentitas;
            $insertUser->no_hp = $noHp;
            $insertUser->alamat = $alamat;
            $insertUser->is_active = true;
            $insertUser->role = 'user';

            $insertUser->save();
            
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    $error = "Registrasi Gagal! User sudah terdaftar";
                    break;

                default:
                    $error = "backend error ".$e->getCode()." ".$e->getMessage();
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
