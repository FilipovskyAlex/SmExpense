<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Period
 * @package App
 */
class Period extends Model
{
    /**
     * @var string
     */
    protected $table = 'periods';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'from', 'to'];
}
