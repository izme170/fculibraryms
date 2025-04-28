<?php

use App\Events\PatronLoggedIn;
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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\MaterialCopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout']);

Route::controller(PatronController::class)->group(function () {
    Route::get('/get-patron/{rfid}', 'getPatron')->name('patron.getPatron');
});

Route::get('/opac', [MaterialController::class, 'opac']);

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
        Route::get('/users/archives', 'archives')->name('users.archives');
        Route::get('/user/create', 'create')->name('users.create');
        Route::post('/user/store', 'store');
        Route::get('/user/show/{id}', 'show')->name('users.show');
        Route::put('/user/update/{id}', 'update');
        Route::put('/user/update-image/{id}', 'updateImage');
        Route::put('/user/toggle/archive/{id}', 'toggleArchive');
        Route::put('/user/change-password/{id}', 'changePassword');
        Route::get('/users/export', 'export')->name('users.export');
        Route::put('/user/toggle/status/{id}', 'toggleStatus');
    });

    Route::controller(RoleController::class)->group(function () {
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
        Route::get('/patrons/archives', 'archives')->name('patrons.archives');
        Route::get('/patron/create', 'create')->name('patrons.create');
        Route::get('/courses/{department_id}', 'getCoursesByDepartment');
        Route::post('/patron/store', 'store');
        Route::get('/patron/show/{id}', 'show')->name('patrons.show');
        Route::put('/patron/update/{id}', 'update');
        Route::put('/patron/archive/{id}', 'archive');
        Route::get('/patron/unarchive/{id}', 'unarchive');
        Route::put('/patron/new_rfid/{id}', 'newRFID');
        Route::put('/patron/update-image/{id}', 'updateImage');
        Route::get('/patrons/export', 'export')->name('patrons.export');
        Route::post('/patrons/import', 'import')->name('patrons.import');
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
        Route::get('/materials/archives', 'archives')->name('materials.archives');
        Route::get('/material/unarchive/{id}', 'unarchive')->name('materials.unarchive');
        Route::get('/materials/export', 'export');
        Route::post('/materials/import', 'import')->name('materials.import');
    });

    Route::controller(MaterialCopyController::class)->group(function () {
        Route::get('/material-copies', 'index')->name('material-copies.index');
        Route::get('/material-copies/archives', 'archives')->name('material-copies.archives');
        Route::get('/copy/show/{material_id}', 'show');
        Route::get('/create-copy/{id}', 'create');
        Route::post('/material/store-copy/{id}', 'store');
        Route::put('/material/update/copy/{id}', 'update');
        Route::put('/material/archive/copy/{id}', 'archive');
        Route::get('/material/unarchive/copy/{id}', 'unarchive');
        Route::put('/material/copy/update_rfid/{id}', 'updateRFID');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::get('/reports/login-statistics', 'loginStatistics')->name('reports.loginStatistics');
        Route::get('/reports/monthly-login-statistics', 'monthlyLoginStatistics')->name('reports.monthlyLoginStatistics');
        Route::get('/reports/unreturned-materials', 'unreturnedMaterials')->name('reports.unreturnedMaterials');
        Route::get('/reports/borrowed-materials', 'borrowedMaterial')->name('reports.borrowedMaterials');
        Route::post('/reports/export/top-library-users', 'exportTopLibraryUsers')->name('export.topLibraryUsers');
        Route::post('/reports/export/top-marketers', 'exportTopMarketers')->name('export.topMarketers');
        Route::post('/reports/export/top-departments', 'exportTopDepartments')->name('export.topDepartments');
        Route::get('/reports/login-statistics/export', [ReportController::class, 'exportLoginStatistics'])->name('reports.login_statistics.export');
        Route::get('/reports/login-statistics-data/export', [ReportController::class, 'exportLoginStatisticsData'])->name('reports.login_statistics_data.export');
        Route::get('/reports/monthly-login-statistics/export', [ReportController::class, 'exportMonthlyLoginStatistics'])->name('reports.monthly_login_statistics.export');
        Route::get('/reports/unreturned-materials/export', [ReportController::class, 'exportUnreturnedMaterials'])->name('reports.unreturned_materials.export');
        Route::post('/reports/borrowed-materials/export', [ReportController::class, 'exportBorrowedMaterials'])->name('reports.borrowed_materials.export');
    });

    Route::controller(BorrowMaterialController::class)->group(function () {
        Route::get('/borrowed-materials', 'index')->name('borrowed-materials.index');
        Route::get('/borrowed-material/show/{material_id}', 'show');
        Route::get('/borrow-material', 'create')->name('borrowed-materials.borrowMaterial');
        Route::post('/borrow-material/process', 'store');
        Route::get('/return-material', 'edit')->name('materials.returnMaterial');
        Route::put('/return-material/process', 'update');
        Route::get('/borrowed-materials/export', 'export')->name('borrowed-materials.export');
    });

    Route::controller(PatronLoginController::class)->group(function () {
        Route::get('/patron-logins', 'index')->name('patron-logins.index');
        Route::get('/patron-logins/export', 'export')->name('patron-logins.export');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::put('/setting/update/fine', 'setFine')->name('setting.updateFine');
    });
});
