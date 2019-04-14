<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class ExpenseController
 * @package App\Http\Controllers
 */
class ExpenseController extends Controller
{
    /**
     * ExpenseController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
