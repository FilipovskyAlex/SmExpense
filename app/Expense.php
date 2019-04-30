<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getAllExpenses()
    {
        return DB::select(DB::raw('
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
        '));
    }

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
