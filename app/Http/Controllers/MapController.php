<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\KidopiCovidApiService;

class MapController extends Controller
{
    private $kidopiCovidApiService;

    public function __construct(
        KidopiCovidApiService $kidopiCovidApiService
    ){
        $this->kidopiCovidApiService = $kidopiCovidApiService;
    }

    public function index(){
        $geojson = file_get_contents(storage_path('app/public/countries.geojson'));

        $countriesList = $this->kidopiCovidApiService->getCountriesList();
        $covidCountryData = $this->kidopiCovidApiService->getCovidDataByCountry("Brazil");

        return view('index', [
            'geojson' => $geojson,
            'countriesList' => $countriesList,
            'covidCountryData' => $covidCountryData
        ]);
    }
}
