<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Expense;
use App\Period;
use App\Providers\CommonProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $this->budgets = new Budget();
        $this->categories = new Category();
        $this->periods = new Period();
        $this->expenses = new Expense();
        $this->colors = CommonProvider::colors();
    }

    public function index()
    {
        if(Auth::user()->company_id == null) {
            return redirect()->route('companies.index')->with('error', 'Please select / create your company first');
        }

        if(Auth::user()->role == 3) {
            return redirect()->route('home')->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $data['periods'] = $this->periods->getPeriodsByUser();
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['colors'] = $this->colors;
        $data['budgets'] = $this->budgets->getBudgetById();

        return view('expenses.index');
    }

    public function create()
    {
        if(Auth::user()->company_id == null) {
            return redirect()->route('companies.index')->with('error', 'Please select / create your company first');
        }

        if(Auth::user()->role == 3) {
            return redirect()->route('home')->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $data['budgets'] = $this->budgets->getBudgetById();
        $data['periods'] = $this->periods->getPeriodsByUser();

        return view('expenses.create', $data);
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function show()
    {
        return view('expenses.showSingle');
    }

    public function delete()
    {

    }
}
