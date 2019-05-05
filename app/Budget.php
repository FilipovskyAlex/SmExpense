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

        // User and manager can see only their self-created budgets for their categories and choosing companies
        if(Auth::user()->role != 1) {
            $AND = "
                AND cat.id IN(
                    SELECT ud.category_id
                    FROM user_details as ud
                    WHERE ud.user_id=".Auth::user()->id."
                )
            ";
        }

        // Add query raw to common query if we choose particular department to display its budgets
        if(Input::get('department') && Input::get('department') != "all") {
            $department = "AND b.category_id=".Input::get('department')."";
        }

        // Add query raw to common query if we choose particular period to display its budgets
        if(Input::get('period') && Input::get('period') != "all") {
            $period = "AND b.period_id=".Input::get('period')."";
        }

        // CASE: we send as outside param the diff btw budget and summary prices of all expenses that belongs to this budget
        return DB::select(DB::raw("
            SELECT b.id, b.company_id, b.category_id, b.period_id, b.budget, b.item, b.unit, b.quantity, b.created_at, u.name as name, cat.name as category,
            CASE 
            WHEN b.budget - SUM(e.price)>0
            THEN b.budget - SUM(e.price)
            ELSE b.budget
            END as outside
            FROM budgets as b
            LEFT JOIN users as u ON b.user_id=u.id
            LEFT JOIN categories as cat ON b.category_id=cat.id
            LEFT JOIN companies as c ON b.company_id=c.id
            LEFT JOIN expenses as e ON e.budget_id=b.id
            WHERE b.company_id=$company_id
            $department
            $period
            $AND
            GROUP BY b.id
            ORDER BY b.id DESC
        "));
    }

    /**
     * Fetch total budget and spend budget by all expenses
     * @return array
     */
    public function getTotalBudget()
    {
        $company_id = Auth::user()->company_id;

        $AND = '';

        if(Auth::user()->id != 1) {
            $AND = "
                AND category_id IN(
                    SELECT ud.category_id
                    FROM user_details as ud
                    WHERE ud.user_id=".Auth::user()->id."
                )
            ";
        }

        return DB::select(DB::raw("
            SELECT  SUM(b.budget) as totalBudgets
            FROM budgets as b
            WHERE b.company_id=$company_id
            $AND

            UNION

            SELECT SUM(price) as spendBudgets 
            FROM expenses
            WHERE company_id=$company_id
            $AND
        "));
    }
}
