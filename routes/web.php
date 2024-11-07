<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // If user is authenticated, redirect to /home
        return redirect()->route('home');
    }
    // If not authenticated, redirect to login
    return redirect()->route('landing');
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

    Route::controller(HomeController::class)->group(function () {
        Route::get('/landing', 'landing')->name('landing');
    });
});

Route::group(['middleware' => 'auth'], function () {
    // Home
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
    });

    // Admin
    Route::group(['middleware' => 'is_admin'], function () {
        Route::controller(AdminController::class)->group(function () {
            // User Management
            Route::get('/admin/users', 'listUsers')->name('admin.users.list');
            Route::get('/admin/users/{id}/edit', 'editUser')->name('admin.users.edit');
            Route::put('/admin/users/{id}', 'updateUser')->name('admin.users.update');
            Route::delete('/admin/users/{id}', 'deleteUser')->name('admin.users.delete');

            // Book Management

        })->name('admin.');
    });

    // Logout
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    });
});
