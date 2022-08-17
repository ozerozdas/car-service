<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrdersController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::get('logout', [ApiController::class, 'logout']);

Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1'], function() {
    ## Services
    Route::get('/services', [ServicesController::class, 'index']);

    ## Account
    Route::post('/userBalance', [AccountController::class, 'addBalance']);

    ## Orders
    Route::get('/orders', [OrdersController::class, 'getOrders']);
    Route::post('/orders', [OrdersController::class, 'setOrder']);
});
