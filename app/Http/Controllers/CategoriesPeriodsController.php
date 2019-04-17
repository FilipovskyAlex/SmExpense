<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class CategoriesPeriodsController
 * @package App\Http\Controllers
 */
class CategoriesPeriodsController extends Controller
{
    /**
     * CategoriesPeriodsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
