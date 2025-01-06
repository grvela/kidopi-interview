<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;  // Adicionando o cache
use App\DTOs\CovidDataDTO;
use App\DTOs\CountriesListDTO;

class KidopiCovidApiService
{
    public function getCovidDataByCountry($state)
    {
        // Definindo uma chave única de cache para o estado
        $cacheKey = "covid_data_{$state}";

        // Verificando se já temos os dados no cache
        $data = Cache::remember($cacheKey, 600, function () use ($state) {
            $response = Http::get("https://dev.kidopilabs.com.br/exercicio/covid.php?pais=" . $state);

            if ($response->successful()) {
                return $response->json();
            }

            return null; 
        });

        // Se não houver dados no cache, retornamos null
        if (!$data) {
            return null;
        }

        // Processando os dados do estado
        return collect($data)->map(function ($item) {
            return new CovidDataDTO(
                $item['ProvinciaEstado'],
                $item['Pais'],
                $item['Confirmados'],
                $item['Mortos']
            );
        });
    }

    public function getCountriesList()
    {
        // Definindo uma chave única de cache para a lista de países
        $cacheKey = "countries_list";

        // Verificando se já temos os dados no cache
        $countries = Cache::remember($cacheKey, 600, function () {
            $response = Http::get("https://dev.kidopilabs.com.br/exercicio/covid.php?listar_paises=1");

            if ($response->successful()) {
                return $response->json();
            }

            return null; 
        });

        // Se não houver dados no cache, retornamos null
        if (!$countries) {
            return null;
        }

        // Processando os dados dos países
        return collect($countries)->map(function ($country) {
            return new CountriesListDTO($country);
        });
    }
}
