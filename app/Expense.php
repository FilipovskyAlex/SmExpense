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

    public function user_details()
    {
        $table = DB::table('user_details');

        $table = $table->where('user_id', Auth::user()->id);
        $table = $table->where('company_id', Auth::user()->company_id);

        return $table;
    }


    public function getAllExpenses()
    {
        $company_id = Auth::user()->company_id;

        $department = Input::get('department');
        $period = Input::get('period');
        $status = Input::get('status');
        $search = Input::get('search');

        $table = DB::table('expenses as e');

        $table = $table->select(
            'e.id',
            'e.price',
            'e.outside as budget',
            'e.priority',
            'e.status',
            'e.subject',
            'e.description',
            'e.comment',
            'e.approver_id as approver',
            'e.company_id',
            'e.created_at',
            'e.updated_at',
            'e.file',
            'u.name as user',
            'u.logo as logo',
            'u.email',
            'b.item',
            'cat.name as category',
            'p.id as period',
            'app.name as approver_name',
            'app.logo as approver_logo'
        );

        $table = $table->leftJoin('companies as comp','comp.id', '=', 'e.company_id');
        $table = $table->leftJoin('budgets as b','b.id', '=', 'e.budget_id');
        $table = $table->leftJoin('categories as cat','cat.id', '=', 'e.category_id');
        $table = $table->leftJoin('users as u','u.id', '=', 'e.user_id');
        $table = $table->leftJoin('users as app','app.id', '=', 'e.approver_id');
        $table = $table->leftJoin('periods as p','p.id', '=', 'e.period_id');

        $table = $table->where('e.company_id', '=', $company_id);

        // User and manager can see only their self-created expenses for their categories and choosing companies
//        if(Auth::user()->role != 1) {
//            $table = $table->whereIn('e.category_id', $this->user_details());
//        }

        // Add query raw to common query if we choose particular department to display its budgets
        if($department && $department != "all") {
            $table = $table->where('b.category_id', $department);
        }

        // Add query raw to common query if we choose particular period to display its budgets
        if($status && $status != "all") {
            $table = $table->where('e.status', $status);
        }

        // Add query raw to common query if we choose particular period to display its budgets
        if($period && $period != "all") {
            $table = $table->where('b.period_id', $period);
        }

        // Create search conditions
        if($search) {
            $table = $table->where('e.id', 'like', $search);
            $table = $table->orWhere('u.name', 'like', '%'.$search.'%');
            $table = $table->orWhere('u.email', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.subject', 'like', '%'.$search.'%');
            $table = $table->orWhere('b.item', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.price', 'like', '%'.$search.'%');
            $table = $table->orWhere('cat.name', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.status', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.outside', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.created_at', 'like', '%'.$search.'%');
            $table = $table->orWhere('e.priority', 'like', '%'.$search.'%');
            $table = $table->orWhere('app.name', 'like', '%'.$search.'%');
        }

//        $table = $table->groupBy('e.id');
        $table = $table->orderBy('created_at', 'DESC');
        $table = $table->paginate(2);

        return $table;
    }

    /**
     * Fetch single expense to display
     * @param int $id
     * @return array
     */
    public function getSingleExpense(int $id)
    {
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
            e.file,
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
            WHERE e.id=$id
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

    /**
     * @param string $status
     * @return int|string
     */
    public static function getStatusByString(string $status)
    {
        switch ($status) {
            case 'approved': return 1; break;
            case 'denied': return 2; break;
            case 'pending': return 3; break;
            case 'closed': return 4; break;
            default: return 'No such status'; break;
        }
    }

    public function dashboardData(int $user_id, int $company_id, int $status)
    {
        $table = DB::table('expenses');

        $table = $table->select('*');
        $table = $table->where('user_id', $user_id);
        $table = $table->where('company_id', $company_id);
        $table = $table->where('status', $status);

        $result = $table->count();

        return $result;
    }
}
