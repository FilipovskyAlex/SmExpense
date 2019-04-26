<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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

    /**
     * Fetch budgets
     * @return array
     */
    public function getBudgetById()
    {
        $company_id = Auth::user()->company_id;

        $department = "";
        $period = "";
        $AND = "";

        // Add query raw to common query if we choose particular department to display its budgets
        if(Input::get('department') && Input::get('department') != "all") {
            $department = "AND b.category_id=".Input::get('department')."";
        }

        // Add query raw to common query if we choose particular period to display its budgets
        if(Input::get('period') && Input::get('period') != "all") {
            $period = "AND b.period_id=".Input::get('period')."";
        }

        return DB::select(DB::raw("
            SELECT b.id, b.company_id, b.category_id, b.period_id, b.item, b.unit, b.quantity, b.budget, b.created_at, u.name as name
            FROM budgets as b 
            LEFT JOIN users as u ON b.user_id=u.id
            LEFT JOIN categories as cat ON b.category_id=cat.id
            LEFT JOIN companies as c ON b.company_id=c.id
            WHERE b.company_id=$company_id
            $department
            $AND
            $period
            ORDER BY b.id DESC
        "));
    }
}
