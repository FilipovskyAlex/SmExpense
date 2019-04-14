<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class PeriodController
 * @package App\Http\Controllers
 */
class PeriodController extends Controller
{
    /**
     * PeriodController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
