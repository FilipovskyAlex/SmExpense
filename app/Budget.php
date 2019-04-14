<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budgets';

    protected $fillable = ['user_id', 'company_id', 'category_id', 'period_id', 'item', 'unit', 'quantity', 'budget'];
}
