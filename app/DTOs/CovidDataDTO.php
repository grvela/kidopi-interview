<?php

namespace App\DTOs;

class CovidDataDTO
{
    public string $province;
    public string $country;
    public int $confirmed;
    public int $deaths;

    public function __construct(string $province, string $country, int $confirmed, int $deaths)
    {
        $this->province = $province;
        $this->country = $country;
        $this->confirmed = $confirmed;
        $this->deaths = $deaths;
    }
}
