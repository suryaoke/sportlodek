<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MerchantController;
use App\Http\Controllers\Admin\ProfileAdminControllerr;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route admin //

Route::group(
    [
        "middleware" => "auth",
        "verified",
        "role:admin",
        "prefix" => "admin",
        "as" => "admin."
    ],
    function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/pofile', [ProfileAdminControllerr::class, 'profile'])->name('profile');

        Route::patch('/profile', [ProfileAdminControllerr::class, 'update'])->name('profile.update');

        Route::post('/profile/image', [ProfileAdminControllerr::class, 'storeImage'])->name('profile.store.image');

        Route::delete('/profile/delete', [ProfileAdminControllerr::class, 'destroy'])->name('profile.delete');

        Route::get('/password', [ProfileAdminControllerr::class, 'password'])->name('password');

        Route::resource('merchant', MerchantController::class);

        Route::post('merchant/akun', [MerchantController::class, 'akunStore'])->name('merchant.akun');

        Route::post('merchant/akun', [MerchantController::class, 'akunStore'])->name('merchant.akun');

        Route::get('merchant/detail/{merchant}/{id?}', [MerchantController::class, 'detail'])->name('merchant.detail');

        Route::post('merchant/detail', [MerchantController::class, 'detailStore'])->name('merchant.detail.store');

        Route::delete('merchant/detail/delete/{id}', [MerchantController::class, 'mechantDetailDestroy'])->name('merchant.detail.destroy');

        Route::post('merchant/detail/update', [MerchantController::class, 'detailUpdate'])->name('merchant.detail.update');

        Route::put('merchant/detail/status', [MerchantController::class, 'merchantDetailStatusUpdate'])->name('merchantdetail-status.update');

        Route::post('merchant/detail/category', [MerchantController::class, 'categoryStore'])->name('merchant.category.store');

        Route::post('merchant/detail/category', [MerchantController::class, 'categoryStore'])->name('merchant.category.store');

        Route::post('merchant/detail/category/update', [MerchantController::class, 'categoryUpdate'])->name('merchant.category.update');

        Route::delete('merchant/category/delete/{id}', [MerchantController::class, 'mechantCategoryDestroy'])->name('merchant.category.destroy');

        Route::get('schedule', [ScheduleController::class, 'index'])->name('merchant.schedule');

        Route::get('schedule/detail/{merchant}/price/{id?}/{scheduleId?}/{scheduleDetailId?}', [ScheduleController::class, 'detail'])->name('schedule.detail');

        Route::post('schedule/create', [ScheduleController::class, 'store'])->name('schedule.store');

        Route::post('schedule/update', [ScheduleController::class, 'update'])->name('schedule.update');


        Route::delete('schedule/delete/{id}', [ScheduleController::class, 'scheduleDestroy'])->name('schedule.destroy');

        Route::post('schedule/detail/create', [ScheduleController::class, 'schedulDetailStore'])->name('schedule.detail.store');


        Route::post('schedule/detail/update', [ScheduleController::class, 'scheduleDetailUpdate'])->name('schedule.detail.update');

        Route::delete('schedule/detail/delete/{id}', [ScheduleController::class, 'scheduleDetailDestroy'])->name('schedule.detail.destroy');



        Route::get('schedule/booking', [BookingController::class, 'index'])->name('merchant.schedule.booking');

        Route::get('schedule/booking/detail/{merchant}/price/{id?}/{scheduleId?}/{scheduleDetailId?}', [BookingController::class, 'detail'])->name('schedule.detail.booking');
    }
);

require __DIR__ . '/auth.php';
