<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowBookController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/get-patron/{rfid}', 'getPatron');
});

Route::controller(PatronLoginController::class)->group(function () {
    Route::get('/patrons/login', 'create');
    Route::post('/patrons/login/store', 'store');
    Route::get('/patrons/logout', 'edit');
    Route::put('/patrons/logout/update', 'update');
});

// Route::get('/admin/patron/qrcode/send-to-email/{id}', [PatronController::class, 'sendQRCodeToEmail']);

Route::middleware('adminMiddleware')->group(function () {

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

    Route::controller(BookController::class)->group(function () {
        Route::get('/admin/books', 'index');
        Route::get('/admin/book/create', 'create');
        Route::post('/admin/book/store', 'store');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/admin/activities', 'index');
    });
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function (){
        Route::get('/user/dashboard', 'index');
    });

    Route::controller(BorrowBookController::class)->group(function () {
        Route::get('/borrowed-books', 'index');
        Route::get('/borrow-book', 'create');
        Route::post('/borrow-book/process', 'store');
        Route::get('/return-book', 'edit');
        Route::put('/return-book/process', 'update');
    });

    Route::controller(PatronLoginController::class)->group(function () {
        Route::get('/patron-logins', 'index');
    });
});