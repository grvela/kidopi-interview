<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CovidController;

Route::get('/covid/{state}', [CovidController::class, 'getCovidDataByCountry']);
Route::get('/countries', [CovidController::class, 'getAllCountries']);