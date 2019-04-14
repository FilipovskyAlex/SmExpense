<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class BudgetController
 * @package App\Http\Controllers
 */
class BudgetController extends Controller
{
    /**
     * BudgetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
