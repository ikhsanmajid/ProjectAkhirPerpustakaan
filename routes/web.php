<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ReturnController;

Route::get("/", [CatalogController::class,"index"])->name('index');
Route::get('/books/{book}', [CatalogController::class, 'show'])->name('catalog.show');

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

    // Route::controller(HomeController::class)->group(function () {
    //     Route::get('/landing', 'landing')->name('landing');
    // });
});

Route::group(['middleware' => 'auth'], function () {

    // Admin
    Route::group(['middleware' => 'is_admin'], function () {
        // Home
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('home');
        });

        Route::controller(AdminController::class)->group(function () {
            // User Management
            Route::get('/admin/users/create', 'createUser')->name('admin.users.create');
            Route::post('/admin/users/create', 'storeUser')->name('admin.users.store');
            Route::get('/admin/users', 'listUsers')->name('admin.users.list');
            Route::get('/admin/users/{id}/edit', 'editUser')->name('admin.users.edit');
            Route::put('/admin/users/{id}', 'updateUser')->name('admin.users.update');
            Route::delete('/admin/users/{id}', 'deleteUser')->name('admin.users.delete');
            // Search Users
            Route::get('admin/users/search', 'search')->name('admin.users.search');
        })->name('admin.');

        // Search Books
        Route::get('admin/books/search', [BookController::class, 'search'])->name('admin.books.search');
        
        // Route resource untuk manajemen buku
        Route::resource('admin/books', BookController::class)->names('admin.books');
        Route::resource('admin/categories', CategoryController::class)->names('admin.categories');

        Route::get('admin/borrow/scanner', [BorrowController::class, 'scannerView'])->name('admin.borrow.scanner');
        Route::resource('admin/borrow', BorrowController::class)->names('admin.borrow');
        Route::resource('admin/return', ReturnController::class)->names('admin.return');


        

    });

    // Route::get('/home', function() {
    //     return redirect('/');  // Redirect non-admins to the catalog page
    // });

    // Logout
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    });
});
