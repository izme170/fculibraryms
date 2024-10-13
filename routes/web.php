<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\PatronLoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
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
    Route::post('/patrons/logout/process', 'logoutProcess');
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
        Route::get('/users/export', 'export');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('/roles', 'index');
        Route::post('/role/store', 'store');
        Route::put('/role/update/{id}', 'update');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index');
    });

    Route::controller(OptionController::class)->group(function () {
        Route::get('/options', 'index');
        Route::post('/adviser/store', 'storeAdviser');
        Route::post('/category/store', 'storeCategory');
        Route::post('/course/store', 'storeCourse');
        Route::post('/department/store', 'storeDepartment');
    });
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/user/dashboard', 'index');
    });

    Route::controller(PatronController::class)->group(function () {
        Route::get('/patrons', 'index');
        Route::get('/patron/create', 'create');
        Route::get('/courses/{department_id}', 'getCoursesByDepartment');
        Route::post('/patron/store', 'store');
        Route::get('/patron/show/{id}', 'show');
        Route::put('/patron/update/{id}', 'update');
        Route::put('/patron/archive/{id}', 'archive');
        Route::put('/patron/new_rfid/{id}', 'newRFID');
        Route::get('/patrons/export', 'export');
    });

    Route::controller(BookController::class)->group(function () {
        Route::get('/books', 'index');
        Route::get('/book/create', 'create');
        Route::post('/book/store', 'store');
        Route::get('/book/show/{id}', 'show');
        Route::put('/book/update/{id}', 'update');
        Route::put('/book/archive/{id}', 'archive');
        Route::put('/book/new_rfid/{id}', 'newRFID');
        Route::get('/books/export', 'export');
    });

    Route::controller(ReportController::class)->group(function(){
        Route::get('/reports', 'index');
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
