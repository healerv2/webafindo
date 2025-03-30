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
    AreaController,
    MikrotikController,
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
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        //Permissions
        Route::resource('/permissions', PermissionController::class);
        //Users
        Route::resource('/users', UserController::class);
        //Users
        Route::resource('/profile', ProfileController::class);
        // Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update/profile', [ProfileController::class, 'updateProfile'])->name('profile.update_profile');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password_update');
        //Data paket
        Route::resource('/data-paket', DataPaketController::class);
        //Data area
        Route::resource('/data-area', AreaController::class);
        //Mikrotik
        Route::resource('/mikrotik', MikrotikController::class);
    });
});
