<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryZone extends Model
{
    protected $table = 'country_zones';

    protected $fillable = ['code', 'name'];
}
