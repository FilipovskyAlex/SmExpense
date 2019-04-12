<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

/**
 * Class CountryZone
 * @package App
 */
class CountryZone extends Model
{
    /**
     * @var string
     */
    protected $table = 'country_zones';

    /**
     * @var array
     */
    protected $fillable = ['code', 'name'];

    /**
     * Fetch a list of country zones according to the country id
     * @return mixed
     */
    public function zones()
    {
        $country_id = Input::get('id');

        return CountryZone::where('country_id', $country_id)->get();
    }
}
