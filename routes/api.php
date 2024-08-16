<?php

use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardDetailController;

Route::get('bookings', [BookingController::class, 'index']);
Route::post('bookings', [BookingController::class, 'store']);
Route::get('bookings/{id}', [BookingController::class, 'show']);
Route::put('bookings/{id}', [BookingController::class, 'update']);
Route::delete('bookings/{id}', [BookingController::class, 'destroy']);

Route::prefix('card-details')->group(function () {
    Route::post('/', [CardDetailController::class, 'store']);
    Route::get('/', [CardDetailController::class, 'index']);
    Route::get('/{id}', [CardDetailController::class, 'show']);
    Route::put('/{id}', [CardDetailController::class, 'update']);
    Route::delete('/{id}', [CardDetailController::class, 'destroy']);
});
Route::get('/cars/search', [CarController::class, 'search']);

Route::prefix('cars')->group(function () {
    Route::get('/', [CarController::class, 'index']);
    Route::post('/', [CarController::class, 'store']);
    Route::get('{car}', [CarController::class, 'show']);
    Route::put('{car}', [CarController::class, 'update']);
    Route::delete('{car}', [CarController::class, 'destroy']);
});

Route::prefix('branches')->group(function() {
    Route::get('/', [BranchController::class, 'index']);
    Route::get('/{id}', [BranchController::class, 'show']);
    Route::post('/', [BranchController::class, 'store']);
    Route::put('/{id}', [BranchController::class, 'update']);
    Route::delete('/{id}', [BranchController::class, 'destroy']);
    Route::get('nearest', [BranchController::class, 'nearest']);
    Route::get('search', [BranchController::class, 'search']);
    Route::post('login-as-branch', [BranchController::class, 'login']);


});









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
