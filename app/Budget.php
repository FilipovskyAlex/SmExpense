<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Budget
 * @package App
 */
class Budget extends Model
{
    /**
     * @var string
     */
    protected $table = 'budgets';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'company_id', 'category_id', 'period_id', 'item', 'unit', 'quantity', 'budget'];
}
