<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\EmployeeApiController;
use App\Http\Controllers\Api\V1\LeaveApiController;
use App\Http\Controllers\Api\V1\PayslipApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);

        Route::get('/employees', [EmployeeApiController::class, 'index']);
        Route::post('/leave/apply', [LeaveApiController::class, 'apply']);
        Route::get('/payslip/{employee_id}/{month}', [PayslipApiController::class, 'show']);
    });
});