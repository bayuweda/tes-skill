<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('todos', TodoController::class);

Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/bookings/{vehicles}', [BookingController::class, 'index']);
