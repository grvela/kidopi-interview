<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KidopiCovidApiService;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CovidController extends Controller
{
    /**
     * Get COVID-19 data by country.
     *
     * @param  string  $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCovidDataByCountry($country)
    {
        try {
            $data = KidopiCovidApiService::getCovidDataByCountry($country);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    /**
     * Get the list of all countries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCountries()
    {
        try {
            $data = KidopiCovidApiService::getAllCountries();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
