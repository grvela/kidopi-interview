<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastAccessToKidopiCovidApi extends Model
{
    use HasFactory;

    protected $table = "kidopi_covid_api";

    protected $fillable = ['name', 'accessed_at' , 'created_at', 'updated_at'];
}
