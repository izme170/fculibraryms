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
    Route::post('/patrons/login/update', 'update');
    Route::get('/patrons/logout', 'logout');
    Route::put('/patrons/logout/process', 'logoutProcess');
});

Route::middleware('adminMiddleware')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/user/create', 'create');
        Route::post('/user/store', 'store');
        Route::get('/user/show/{id}', 'show');
        Route::put('/user/update/{id}', 'update');
        Route::put('/user/archive/{id}', 'archive');
        Route::put('/user/change-password/{id}', 'changePassword');
    });

    Route::controller(PatronController::class)->group(function () {
        Route::get('/patrons', 'index');
        Route::get('/patron/create', 'create');
        Route::post('/patron/store', 'store');
        Route::get('/patron/show/{id}', 'show');
        Route::put('/patron/update/{id}', 'update');
        Route::put('/patron/archive/{id}', 'archive');
        Route::put('/patron/new_rfid/{id}', 'newRFID');
    });

    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index');
        Route::get('/book/create', 'create');
        Route::post('/book/store', 'store');
        Route::get('/book/show/{id}', 'show');
        Route::put('/book/update/{id}', 'update');
        Route::put('/book/archive/{id}', 'archive');
        Route::put('/book/new_rfid/{id}', 'newRFID');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index');
    });

    Route::controller(DashboardController::class)->group(function (){
        Route::get('/user/dashboard', 'index');
    });
});

Route::middleware('auth')->group(function () {

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
