<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
