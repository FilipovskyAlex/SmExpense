<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'state',
        'city',
        'address',
        'post_code',
        'logo',
        'status',
        'company_id',
        'company_name',
        'role',
        'access',
        'parent_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Add One To Many relation between companies and users tables
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    public function roles()
    {
        return DB::table('roles')->get();
    }

    public function getUsersById(int $id = null)
    {
        $parent_id = Auth::user()->parent_id;

        if($parent_id == 0) {
            $parent_id = Auth::user()->id;
        }

        $table = DB::table('users as u')->where('u.parent_id', $parent_id);

        if($id != null) {
            $table->where('id', $id);
        }

        if($id == null) {
            $table->select('u.id', 'u.name', 'u.email', 'u.phone', 'u.status', 'r.name as role');
            $table->leftJoin('roles as r', 'u.role', '=', 'r.id');
        }

        return $table->get();
    }
}
