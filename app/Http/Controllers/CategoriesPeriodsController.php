<?php

namespace App\Http\Controllers;

use App\Category;
use App\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        $this->categories = new Category();
        $this->periods = new Period();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() : View
    {
        $data['categories'] = $this->categories::where('company_id', Auth::user()->company_id)->orderBy('name', 'ASC')->get();
        $data['periods'] = $this->periods::where('company_id', Auth::user()->company_id)->orderBy('created_at', 'ASC')->get();

        return view('categories_periods.index', $data);
    }
}
