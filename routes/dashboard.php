<?php

use App\Http\Controllers\API\Dashboard\AuthController;
use App\Http\Controllers\API\Dashboard\ImageController;
use App\Http\Controllers\API\Dashboard\SchoolController;
use Illuminate\Support\Facades\Route;

/*===================================
=            admin login           =
===================================*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout']);
Route::post('me', [AuthController::class, 'me']);
/*=====  End of admin login  ======*/

/*===================================
=            school           =
===================================*/
Route::apiResource('schools', SchoolController::class);
/*=====  End of school  ======*/

/*===================================
=            image           =
===================================*/
Route::group(['prefix' => 'images'], function () {
    Route::post('school/{school}/upload', [ImageController::class, 'store']);
});
/*=====  End of image  ======*/
