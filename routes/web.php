<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\PatronLoginController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);

Route::controller(PatronController::class)->group(function () {
    Route::get('/get-patron/{id}', 'getPatron');
});

Route::controller(PatronLoginController::class)->group(function(){
    Route::get('/patrons/login', 'create');
    Route::post('/patron-logins', 'store');
});

Route::get('/admin/patron/qrcode/send-to-email/{id}', [PatronController::class, 'sendQRCodeToEmail']);

Route::middleware('adminMiddleware')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/admin/users', 'index');
        Route::get('/admin/user/create', 'create');
        Route::post('/admin/user/store', 'store');
        Route::get('/admin/user/show/{id}', 'show');
    });

    Route::controller(PatronController::class)->group(function () {
        Route::get('/admin/patrons', 'index');
        Route::get('/admin/patron/create', 'create');
        Route::post('/admin/patron/store', 'store');
        Route::get('/admin/patron/show/{id}', 'show');
    });

    Route::controller(BookController::class)->group(function (){
        Route::get('/admin/books', 'index');
    });
});