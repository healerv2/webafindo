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
    PembukuanController,
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
        //Pembukuan
        Route::resource('/pembukuan', PembukuanController::class);
        Route::get('/pembukuans/get-gaji/view', [PembukuanController::class, 'getPengeluaranGajiView'])->name('pembukuan.get_gaji_view');
        Route::get('/pembukuans/get-gaji', [PembukuanController::class, 'getPengeluaranGaji'])->name('pembukuan.get_gaji');
        Route::get('/pembukuans/get-perbaikan-alat/view', [PembukuanController::class, 'getPengeluaranPerbaikanAlatView'])->name('pembukuan.perbaikan_alat_view');
        Route::get('/pembukuans/get-perbaikan-alat', [PembukuanController::class, 'getPengeluaranPerbaikanAlat'])->name('pembukuan.perbaikan_alat');
        Route::get('/pembukuans/get-pasang-baru/view', [PembukuanController::class, 'getPengeluaranPasangBaruView'])->name('pembukuan.pasang_baru_view');
        Route::get('/pembukuans/get-pasang-baru', [PembukuanController::class, 'getPengeluaranPasangBaru'])->name('pembukuan.pasang_baru');
        Route::get('/pembukuans/get-bandwith/view', [PembukuanController::class, 'getPengeluaranBandwithView'])->name('pembukuan.bandwith_view');
        Route::get('/pembukuans/get-bandwith', [PembukuanController::class, 'getPengeluaranBandwith'])->name('pembukuan.bandwith');
        Route::get('/pembukuans/get-penagihan/view', [PembukuanController::class, 'getPengeluaranBandwithView'])->name('pembukuan.penagihan_view');
        Route::get('/pembukuans/get-penagihan', [PembukuanController::class, 'getPengeluaranBandwith'])->name('pembukuan.penagihan');
        Route::get('/pembukuans/get-listrik-pdam-pulsa/view', [PembukuanController::class, 'getPengeluaranListrikPDAMPulsaView'])->name('pembukuan.lisrik_pdam_pulsa_view');
        Route::get('/pembukuans/get-listrik-pdam-pulsa', [PembukuanController::class, 'getPengeluaranListrikPDAMPulsa'])->name('pembukuan.lisrik_pdam_pulsa');
        Route::get('/pembukuans/get-marketing/view', [PembukuanController::class, 'getPengeluaranMarketingView'])->name('pembukuan.marketing_view');
        Route::get('/pembukuans/get-marketing', [PembukuanController::class, 'getPengeluaranMarketing'])->name('pembukuan.marketing');
        Route::get('/pembukuans/get-lainnya/view', [PembukuanController::class, 'getPengeluaranLainnyaView'])->name('pembukuan.lainnya_view');
        Route::get('/pembukuans/get-lainnya', [PembukuanController::class, 'getPengeluaranLainnya'])->name('pembukuan.lainnya');
        Route::get('/pembukuans/get-pemasukan-lainnya/view', [PembukuanController::class, 'getPemasukanLainnyaView'])->name('pembukuan.pemasukan_lainnya_view');
        Route::get('/pembukuans/get-pemasukan-lainnya', [PembukuanController::class, 'getPemasukanLainnya'])->name('pembukuan.pemasukan_lainnya');
    });
});
