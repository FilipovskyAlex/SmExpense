<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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

    /**
     * Fetch all needed data from expense to display
     * @return array
     */
    public function getAllExpenses()
    {
        $company_id = Auth::user()->company_id;

        $department = "";
        $period = "";
        $status = "";
        $AND = "";

        // User and manager can see only their self-created expenses for their categories and choosing companies
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
        if(Input::get('status') && Input::get('status') != "all") {
            $status = "AND e.status=".Input::get('status')."";
        }

        // Add query raw to common query if we choose particular period to display its budgets
        if(Input::get('period') && Input::get('period') != "all") {
            $period = "AND b.period_id=".Input::get('period')."";
        }

        return DB::select(DB::raw("
            SELECT
            e.id,
            e.outside as budget,
            e.price,
            e.comment,
            e.description,
            e.priority,
            e.subject,
            e.status,
            e.created_at,
            e.updated_at,
            e.approver_id as approver,
            e.company_id,
            u.name as user,
            u.logo as logo,
            u.email,
            b.item,
            cat.name as category,
            p.id as period,
            app.name as approver_name,
            app.logo as approver_logo
            FROM expenses as e
            LEFT JOIN companies as comp ON e.company_id = comp.id
            LEFT JOIN budgets as b ON e.budget_id = b.id
            LEFT JOIN categories as cat ON e.category_id = cat.id
            LEFT JOIN users as u ON e.user_id = u.id
            LEFT JOIN users as app ON e.approver_id = app.id
            LEFT JOIN periods as p ON e.period_id = p.id
            WHERE e.company_id=$company_id
            $department
            $status
            $period
            $AND
            ORDER BY e.created_at DESC
        "));
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getStatus(int $status) : string
    {
        switch ($status) {
            case '1': return 'Approved'; break;
            case '2': return 'Denied'; break;
            case '3': return 'Pending'; break;
            case '4': return 'Closed'; break;
            default: return 'No such status'; break;
        }
    }
}
