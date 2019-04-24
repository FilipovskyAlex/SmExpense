<?php

namespace App\Http\Controllers;

use App\Category;
use App\Period;
use App\Providers\CommonProvider;
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

        $this->categories = new Category();
        $this->periods = new Period();
        $this->colors = CommonProvider::colors();
    }

    public function index()
    {
        return view('budgets.index');
    }

    public function create()
    {
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['periods'] = $this->periods->getPeriodsByUser();

        return view('budgets.create', $data);
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
