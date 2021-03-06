<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class CommonProvider
 * @package App\Providers
 */
class CommonProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Set the border and bg color for list of companies
     * @return array
     */
    public static function colors() : array
    {
        return [
            'blue',
            'indigo',
            'purple',
            'darkRed',
            'green',
            'darkGreen',
            'yellow',
            'orange',
            'teal',
            'cyan',
            'lightBlack',
        ];
    }

    /**
     * @param int $value
     * @return int|string
     */
    public static function format_number(int $value = null)
    {
        $value = number_format($value, 2);
        $value = '$'.$value;
        return $value;
    }

    /**
     * @param $logo
     * @return string
     */
    public static function getImage($logo) : string
    {
        if($logo == null) {
            $logo = asset('img/no_avatar.jpg');
        } else {
            $logo = asset("uploads/$logo");
        }

        return $logo;
    }
}
