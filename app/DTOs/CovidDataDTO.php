<?php

namespace App\DTOs;

class CovidDataDTO
{
    public int $id;
    public string $province;
    public string $country;
    public int $confirmed;
    public int $deaths;

    public function __construct(int $id, string $province, string $country, int $confirmed, int $deaths)
    {
        $this->id = $id;
        $this->province = $province ?: $country;
        $this->country = $country;
        $this->confirmed = $confirmed;
        $this->deaths = $deaths;
    }
}
