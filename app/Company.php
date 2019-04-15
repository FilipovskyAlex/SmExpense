<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
