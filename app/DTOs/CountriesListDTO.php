<?php 

namespace App\DTOs;

class CountriesListDTO
{
    public string $country;

    public function __construct(string $country)
    {
        $this->country = $country;
    }
}
