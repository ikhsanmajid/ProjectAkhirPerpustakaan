<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'guest'], function () {
    // Login
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login');
    });

    // Register
    Route::controller(RegistrationController::class)->group(function () {
        Route::get('/register', 'index');
        Route::post('/register', 'register');
    });
});




Route::group(['middleware' => 'auth'], function () {
    // Home
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
    });



    // Logout
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    });
});
