<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Expense;
use App\Http\Requests\CreateExpenseRequest;
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
        $data['expenses'] = $this->expenses->getAllExpenses();

        return view('expenses.index', $data);
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

    public function store(CreateExpenseRequest $request)
    {
        $validated = $request->all();

        $user_id = Auth::user()->id;

        $expense = ($this->expenses);

        if(Auth::user()->parent_id == 0) {
            $expense->approver_id = Auth::user()->id;
        } else {
            $expense->approver_id = Auth::user()->parent_id;
        }

        $expense->user_id = $user_id;
        $expense->company_id = $validated['company_id'];
        $expense->priority = $validated['priority'];
        $expense->price = $validated['price'];
        $expense->outside = $validated['outside'];
        $expense->subject = $validated['subject'];
        $expense->description = $validated['description'];

        $budget = explode(':', $validated['budget_id']);

        $expense->budget_id = $budget[0];
        $expense->category_id = $budget[2];
        $expense->period_id = $budget[3];

        if($request->file('file') && $request->file('file')->isValid()) {
            $path = './uploads';

            $filename = time().'.'.$validated['file']->getClientOriginalName();

            $request->file('file')->move($path, $filename);

            $expense->file = $filename;
        }

        $expense->save();

        return redirect()->route('expenses.index')->with('message', 'New expense is created');
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
