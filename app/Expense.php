<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * @package App
 */
class Expense extends Model
{
    /**
     * @var string
     */
    protected $table = 'expenses';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'category_id',
        'period_id',
        'budget_id',
        'approver_id',
        'priority',
        'price',
        'outside',
        'subject',
        'description',
        'file',
        'status',
        'comment',
    ];
}
