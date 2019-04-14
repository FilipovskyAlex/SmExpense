<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $table = 'periods';

    protected $fillable = ['company_id', 'from', 'to'];
}
