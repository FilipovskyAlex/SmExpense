<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Company
 * @package App
 */
class Company extends Model
{
    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name'];

    /**
     * Add belongs to relation between users and companies tables
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return array
     */
    public function getCompaniesByUser()
    {
        $user_id = Auth::user()->id;

        if(Auth::user()->parent_id !== 0) {
            $user_id = Auth::user()->parent_id;
        }

        return DB::select(DB::raw("
            SELECT * FROM companies as c WHERE user_id = $user_id ORDER BY name ASC
        "));
    }
}
