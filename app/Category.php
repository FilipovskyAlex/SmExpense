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
    public function getCategoriesByUser($company_id = null)
    {
        $company_id = $company_id == null ? Auth::user()->company_id : $company_id;

        return DB::select(DB::raw("
            SELECT c.id, c.name, c.company_id, c.created_at, c.updated_at
            FROM categories AS c
            WHERE company_id=$company_id
            ORDER BY c.name ASC
        "));
    }
}
