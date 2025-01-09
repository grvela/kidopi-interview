<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\KidopiCovidApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class KidopiCovidApiServiceTest extends TestCase
{
    public function test_get_all_countries_success()
    {
        Http::fake([
            'https://dev.kidopilabs.com.br/exercicio/covid.php?listar_paises=1' => Http::response(['Brazil', 'USA'], 200),
        ]);

        $countries = KidopiCovidApiService::getAllCountries();

        $this->assertCount(2, $countries);
        $this->assertEquals('Brazil', $countries[0]->name);

        $this->assertTrue(Cache::has('countries_list'));
    }

    public function test_get_covid_data_by_country_success()
    {
        Http::fake([
            'https://dev.kidopilabs.com.br/exercicio/covid.php?pais=Brazil' => Http::response([
                ['ProvinciaEstado' => 'SP', 'Pais' => 'Brazil', 'Confirmados' => 1000, 'Mortos' => 50],
            ], 200),
        ]);

        $data = KidopiCovidApiService::getCovidDataByCountry('Brazil');

        $this->assertCount(1, $data);
        $this->assertEquals('Brazil', $data[0]->country);

        $this->assertTrue(Cache::has('covid_data_Brazil'));
    }
}
