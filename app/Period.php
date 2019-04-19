<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Period
 * @package App
 */
class Period extends Model
{
    /**
     * @var string
     */
    protected $table = 'periods';

    /**
     * @var array
     */
    protected $fillable = ['company_id', 'from', 'to'];

    /**
     * @param null $company_id
     * @return array
     */
    public function getPeriodsByUser($company_id = null)
    {
        $company_id = $company_id == null ? Auth::user()->company_id : $company_id;

        return DB::select(DB::raw("
            SELECT p.id, p.company_id, p.`from`, p.`to`, p.created_at, p.updated_at
            FROM periods AS p
            WHERE company_id=$company_id
            ORDER BY created_at ASC
        "));
    }
}
