<?php

use Illuminate\Support\Facades\Route;
use Coderjp\Forecast\Controllers\ForecastController;


Route::get('/forecast', [ForecastController::class, 'index']);
Route::post('/forecast', [ForecastController::class, 'lookup']);