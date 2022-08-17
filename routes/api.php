<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AccountController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::get('logout', [ApiController::class, 'logout']);

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1'], function() {
    Route::get('/services', [ServicesController::class, 'index']);
    Route::post('/userBalance', [AccountController::class, 'addBalance']);
});
