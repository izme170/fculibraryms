<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialCopyController;
use App\Http\Controllers\BorrowMaterialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\PatronController;
use App\Http\Controllers\PatronLoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\MaterialCopy;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);

Route::controller(PatronController::class)->group(function () {
    Route::get('/get-patron/{rfid}', 'getPatron')->name('patron.getPatron');
});

Route::controller(PatronLoginController::class)->group(function () {
    Route::get('/patrons/login', 'create')->name('patrons.create');
    Route::post('/patrons/login/store', 'store');
    Route::post('/patrons/login/update', 'update');
    Route::get('/patrons/logout', 'logout');
    Route::post('/patrons/logout/process', 'logoutProcess');
});

Route::middleware('adminMiddleware')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/user/create', 'create')->name('users.create');
        Route::post('/user/store', 'store');
        Route::get('/user/show/{id}', 'show')->name('users.show');
        Route::put('/user/update/{id}', 'update');
        Route::put('/user/update-image/{id}', 'updateImage');
        Route::put('/user/archive/{id}', 'archive');
        Route::put('/user/change-password/{id}', 'changePassword');
        Route::get('/users/export', 'export')->name('users.export');
        Route::put('/user/deactivate/{id}', 'deactivate');
        Route::put('/user/activate/{id}', 'activate');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('/roles', 'index')->name('users.roles');
        Route::post('/role/store', 'store');
        Route::put('/role/update/{id}', 'update');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index')->name('activities.index');
    });

    Route::controller(DataEntryController::class)->group(function () {
        Route::get('/data-entry', 'index')->name('data-entry.index');
        Route::post('/adviser/store', 'storeAdviser');
        Route::post('/category/store', 'storeCategory');
        Route::post('/course/store', 'storeCourse');
        Route::post('/department/store', 'storeDepartment');
    });
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/user/dashboard', 'index')->name('dashboard');
    });

    Route::controller(PatronController::class)->group(function () {
        Route::get('/patrons', 'index')->name('patrons.index');
        Route::get('/patron/create', 'create')->name('patrons.create');
        Route::get('/courses/{department_id}', 'getCoursesByDepartment');
        Route::post('/patron/store', 'store');
        Route::get('/patron/show/{id}', 'show')->name('patrons.show');
        Route::put('/patron/update/{id}', 'update');
        Route::put('/patron/archive/{id}', 'archive');
        Route::put('/patron/new_rfid/{id}', 'newRFID');
        Route::put('/patron/update-image/{id}', 'updateImage');
        Route::get('/patrons/export', 'export')->name('patrons.export');
        Route::get('/api/courses/{department}', 'getCoursesByDepartment');
    });

    Route::controller(MaterialController::class)->group(function () {
        Route::get('/materials', 'index')->name('materials.index');
        Route::get('/material/create', 'create')->name('materials.create');
        Route::post('/material/store', 'store')->name('materials.store');
        Route::get('/material/show/{id}', 'show')->name('materials.show');
        Route::put('/material/update/{id}', 'update')->name('materials.update');
        Route::put('/material/archive/{id}', 'archive')->name('materials.archive');
        Route::put('/material/new_rfid/{id}', 'newRFID')->name('materials.newRFID');
        Route::put('/material/update-image/{id}', 'updateImage')->name('materials.update_image');
        Route::get('/materials/export', 'export');
    });

    Route::controller(MaterialCopyController::class)->group(function (){
        Route::get('/show-copy/{material_id}', 'show');
        Route::get('/create-copy/{id}', 'create');
        Route::post('/material/store-copy/{id}', 'store');
    });

    Route::controller(ReportController::class)->group(function(){
        Route::get('/reports', 'index')->name('reports.index');
    });

    Route::controller(BorrowMaterialController::class)->group(function () {
        Route::get('/borrowed-materials', 'index')->name('materials.borrowedMaterials');
        Route::get('/borrow-material', 'create')->name('materials.borrowMaterial');
        Route::post('/borrow-material/process', 'store');
        Route::get('/return-material', 'edit')->name('materials.returnMaterial');
        Route::put('/return-material/process', 'update');
    });

    Route::controller(PatronLoginController::class)->group(function () {
        Route::get('/patron-logins', 'index')->name('patron-logins.index');
    });
});
