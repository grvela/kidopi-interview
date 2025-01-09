<?php

namespace App\Http\Controllers;

use App\Services\KidopiCovidApiService;
use App\Services\SentEventService;
use App\Models\LastAccessToKidopiCovidApi;

class CovidController extends Controller
{
    public function getAllCountries()
    {
        try {
            $data = KidopiCovidApiService::getAllCountries();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error to request Kidopi API'], 500);
        }
    }
    public function getCovidDataByCountry($country)
    {
        try {
            $data = KidopiCovidApiService::getCovidDataByCountry($country);

            SentEventService::send($country);

            LastAccessToKidopiCovidApi::create([
                'name' => $country,
                'accessed_at' => now(),
            ]);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error to request Kidopi API'], 500);
        }
    }
}
