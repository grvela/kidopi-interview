<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\DTOs\CovidDataDTO;
use App\DTOs\CountriesListDTO;
use Exception;
class KidopiCovidApiService
{
    private static $baseUrl = "https://dev.kidopilabs.com.br/exercicio/covid.php";

    public static function getAllCountries()
    {
        $cacheKey = "countries_list";
    
        $data = Cache::remember($cacheKey, 600, function () {
            $response = Http::get(self::$baseUrl . "?listar_paises=1");
    
            if (!$response->successful()) {
                Log::error("Error to request All Countries from Kidopi API " . $response->status());
                throw new Exception("Error to request Kidopi API: " . $response->status());
            }
    
            return $response->json();
        });
    
        return collect($data)->map(function ($item, $index) {
            return new CountriesListDTO($index, $item);
        });
    }

    public static function getCovidDataByCountry($state)
    {
        $cacheKey = "covid_data_{$state}";

        $data = Cache::remember($cacheKey, 600, function () use ($state) {
            $response = Http::get(self::$baseUrl . "?pais=" . $state);

            if (!$response->successful()) {
                Log::error("Error to request Covid Country Data from Kidopi API " . $response->status());
                throw new Exception("Error to request Kidopi API: " . $response->status());
            }
    
            return $response->json();
        });

        return collect($data)->map(function ($item, $index) {
            return new CovidDataDTO(
                $index,
                $item['ProvinciaEstado'],
                $item['Pais'],
                $item['Confirmados'],
                $item['Mortos']
            );
        });
    }
}
