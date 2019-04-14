<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class CategoryPeriodsController
 * @package App\Http\Controllers
 */
class CategoryPeriodsController extends Controller
{
    /**
     * CategoryPeriodsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
