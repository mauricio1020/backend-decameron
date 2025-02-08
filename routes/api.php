<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('hotels', HotelController::class);
Route::apiResource('accommodations', AccommodationController::class);
Route::get('/room-types', [RoomTypeController::class, 'index']);
