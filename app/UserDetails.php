<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserDetails
 * @package App
 */
class UserDetails extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_details';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'company_id', 'category_id'];
}
