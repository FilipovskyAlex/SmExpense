<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Category
 * @package App
 */
class Category extends Model
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name'];

    /**
     * @param null $company_id
     * @return array
     */
    public static function getCategoriesByUser($company_id = null)
    {
        $company_id = $company_id == null ? Auth::user()->company_id : $company_id;

        $AND = '';

        if(Auth::user()->role != 1) {
            $AND = "
                AND c.id IN (SELECT ud.category_id FROM user_details AS ud WHERE ud.category_id IS NOT NULL AND ud.user_id=".Auth::user()->id.")
            ";
        }

        return DB::select(DB::raw("
            SELECT c.id, c.name, c.company_id, c.created_at, c.updated_at, b.budgets, b.budgetTotal, e.expenseTotal
            FROM categories AS c
            LEFT JOIN (
                SELECT COUNT(b.id) as budgets, b.company_id, b.category_id, SUM(b.budget) as budgetTotal
                FROM budgets as b
                WHERE b.company_id=$company_id
                GROUP BY b.category_id
            ) b ON b.category_id=c.id
            LEFT JOIN (
                SELECT e.company_id, e.category_id, SUM(e.price) as expenseTotal
                FROM expenses as e
                WHERE e.company_id=$company_id
                GROUP BY e.category_id
            ) e ON e.category_id=c.id
            WHERE c.company_id=$company_id
            $AND
            GROUP BY c.id
            ORDER BY c.name ASC
        "));
    }
}
