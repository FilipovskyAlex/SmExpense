<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getBudgetById()
    {
        $company_id = Auth::user()->company_id;

        return DB::select(DB::raw("
            SELECT b.id, b.company_id, b.category_id, b.period_id, b.item, b.unit, b.quantity, b.budget, b.created_at, u.name as name
            FROM budgets as b 
            LEFT JOIN users as u ON b.user_id=u.id
            LEFT JOIN companies as c ON b.company_id=c.id
            WHERE b.company_id=$company_id
            ORDER BY b.id DESC
        "));
    }
}
