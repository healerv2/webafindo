<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\{
    DashboardController,
    RoleController,
    PermissionController,
    UserController,
    ProfileController,
    DataPaketController,
};

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth',]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        //Roles
        Route::resource('/roles', RoleController::class);
        Route::get('/roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('give.permission.role');
        Route::put('/roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('give.permission.role');
        //Permissions
        Route::resource('/permissions', PermissionController::class);
        //Users
        Route::resource('/users', UserController::class);
        //Users
        Route::resource('/profile', ProfileController::class);
        //Data paket
        Route::resource('/data-paket', DataPaketController::class);
    });
});
