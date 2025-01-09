<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CovidController;

Route::get('/covid/countries', [CovidController::class, 'getAllCountries']);
Route::get('/covid/country/{country}', [CovidController::class, 'getCovidDataByCountry']);