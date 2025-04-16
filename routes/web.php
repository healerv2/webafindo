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
    CustomerController,
    TugasTeknisiController,
};

Route::get('/', function () {
    return redirect()->route('login');
});
//Callback Xendit
Route::post('/payment/xendit/callback', [CustomerController::class, 'handleCallback'])->name('xendit.callback');

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
        Route::get('/user/penagihan', [UserController::class, 'createUserPenagihan'])->name('users.penagihan');
        Route::post('/user/penagihan/add', [UserController::class, 'addUserPenagihan'])->name('users.penagihan_add');
        //Users
        Route::resource('/profile', ProfileController::class);
        Route::post('/profile/update/profile', [ProfileController::class, 'updateProfile'])->name('profile.update_profile');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password_update');
        Route::post('/profile/update-ppn/{id}', [ProfileController::class, 'updatePPN'])->name('profile.ppn_update');
        //Data paket
        Route::resource('/data-paket', DataPaketController::class);
        //Data area
        Route::resource('/data-area', AreaController::class);
        //Mikrotik
        Route::resource('/mikrotik', MikrotikController::class);
        //Customer
        Route::resource('/customer', CustomerController::class);
        //Tagihan
        Route::get('/get-tagihan/customer/{id}', [CustomerController::class, 'getTagihan'])->name('customer.get_tagihan');
        Route::post('/pay-tunai-tagihan/customer/{id}', [CustomerController::class, 'payTunaiTagihan'])->name('customer.pay_tunai_tagihan');
        Route::post('/pay-xendit-tagihan/customer', [CustomerController::class, 'payTagihanXendit'])->name('customer.pay_xendit_tagihan');
        Route::get('/get-pembayaran/customer/', [CustomerController::class, 'viewHistoryPembayaranAdmin'])->name('customer.get_pembayaran_admin');
        //Tugas Teknisi
        Route::resource('/tugas-teknisi', TugasTeknisiController::class);
        Route::get('/teknisi/get-all', [TugasTeknisiController::class, 'getAllTeknisi']);
        Route::get('/teknisi/{id}', [TugasTeknisiController::class, 'getTeknisiById']);
        Route::get('/customers/get-all', [TugasTeknisiController::class, 'getAllCustomers']);
        Route::get('/customers/{id}', [TugasTeknisiController::class, 'getCustomerById']);
    });
});
