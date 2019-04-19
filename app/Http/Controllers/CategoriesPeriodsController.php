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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function index()
    {
        if(Auth::user()->company_id === null) {
            return redirect()->route('company.index')->with('error', 'Please, select / create your company first.');
        }

        $data['categories'] = $this->categories::where('company_id', Auth::user()->company_id)->orderBy('name', 'ASC')->get();
        $data['periods'] = $this->periods::where('company_id', Auth::user()->company_id)->orderBy('created_at', 'ASC')->get();

        return view('categories_periods.index', $data);
    }
}
