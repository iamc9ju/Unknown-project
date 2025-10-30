<?php

use App\Http\Controllers\Farmer\FarmerDashboardController;
use App\Http\Controllers\Farmer\FarmerProfileController;
use App\Http\Controllers\Farmer\FarmerTestController;
use App\Http\Controllers\Farmer\PledgeController;
use App\Http\Controllers\DistrictController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubDistrictController;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\Farmer\FarmerVerifyController;

//Index
Route::get('/', [HomeController::class, 'index'])->name('home');

//Farmer
Route::prefix('farmer')->name('farmer.')->group(function () {
    // Route::get('/dashboard',[FarmerDashboardController::class,'index'])->name('dashboard');
    Route::resource('profile', FarmerProfileController::class);
    // Route::resource('verify',FarmerVerifyController::class);
    Route::resource('pledge', PledgeController::class);
    // Route::get('guarantors', [GuarantorController::class, 'index'])->name('guarantors.index');
    Route::get('report', [FarmerDashboardController::class, 'report'])->name('report');
});

Route::get('/get-districts/{provinceId}', [DistrictController::class, 'getDistricts'])
    ->name('get.districts');

Route::get('/get-subdistricts/{district_id}', [SubDistrictController::class, 'getSubdistricts'])
->name('get.subdistricts');;

//Verify Route
Route::prefix('farmer-verify')->name('farmer-verify.')->group(function(){
    Route::get('/',[FarmerVerifyController::class,'index'])->name('index');
    // ค้นหาเกษตรกร (สำหรับ dropdown autocomplete)
    // Route::get('/search', [FarmerApprovalController::class, 'searchFarmers'])->name('search');

    //แาดงรายการที่รอการรับรอง
    Route::get('/pending/{verifier}',[FarmerVerifyController::class,'getPendingFarmers'])->name('pending');

    // รับรองเกษตรกร
    Route::post('/{farmer}/verify',[FarmerVerifyController::class,'verify'])->name('verify');


});

