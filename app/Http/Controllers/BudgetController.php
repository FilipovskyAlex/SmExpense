<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Http\Requests\CreateBudgetRequest;
use App\Period;
use App\Providers\CommonProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $this->budgets = new Budget();
        $this->categories = new Category();
        $this->periods = new Period();
        $this->colors = CommonProvider::colors();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(Auth::user()->role == 3) {
            return redirect()->route('home')->with('error', 'Access denied, you do not have sufficient privilege');
        }

        if(Auth::user()->company_id == null) {
            return redirect()->route('companies.index')->with('error', 'Please select / create your company first');
        }

        $data['periods'] = $this->periods->getPeriodsByUser();
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['colors'] = $this->colors;
        $data['budgets'] = $this->budgets->getBudgetById();
//dd($data['budgets']);
        return view('budgets.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['periods'] = $this->periods->getPeriodsByUser();

        return view('budgets.create', $data);
    }


    /**
     * @param CreateBudgetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateBudgetRequest $request)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $validated = $request->all();

        $budget = $this->budgets;

        $budget->user_id = Auth::user()->id;
        $budget->company_id = $validated['company_id'];
        $budget->category_id = $validated['department'];
        $budget->period_id = $validated['period'];
        $budget->item = $validated['item'];
        $budget->unit = $validated['unit'];
        $budget->quantity = $validated['quantity'];
        $budget->budget = $validated['budget'];

        $budget->save();

        return redirect()->route('budgets.index')->with('message', 'New budget is created');
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
