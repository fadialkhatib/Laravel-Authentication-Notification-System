<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

Route::post('/send-welcome-email', [EmailController::class, 'send']);



Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    //
    Route::post('/logout',   [AuthController::class, 'logout']);
    Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/profile', function (Request $request) {
        if (! $request->user()->email_verified_at) {
            return response()->json(['message' => 'Email not verified'], 403);
        }

        return $request->user();
    });

    Route::get('/logs', function () {
        return \App\Models\Log::latest()->get();
    });

    Route::get('/failed-jobs', function () {
        return DB::table('failed_jobs')->latest()->get();
    });
    Route::post('/save-device-token', [AuthController::class, 'saveDeviceToken']);
});
