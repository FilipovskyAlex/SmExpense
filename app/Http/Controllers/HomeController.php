<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Category;
use App\Expense;
use App\Period;
use App\Providers\CommonProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        if($company_id == null) {
            return redirect()->route('company.index')->with('error', 'Please, select / create your company first');
        }

        $data['periods'] = $this->periods->getPeriodsByUser();
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['colors'] = $this->colors;
        $data['budgets'] = $this->budgets->getBudgetById();
        $data['expenses'] = $this->expenses->where('company_id', $company_id)->get();
        // 0 index belongs to total budget in current active company
        // 1 index belongs to total spent budget in current active company
        $data['total'] = $this->budgets->getTotalBudget();
        $data['totalBudget'] = $data['total'][0];
        if(isset($data['total'][1])) {
            $data['totalSpendBudget'] = $data['total'][1];
        }

        $data['approved'] = $this->expenses->dashboardData($user_id, $company_id, 1);
        $data['denied'] = $this->expenses->dashboardData($user_id, $company_id, 2);
        $data['pending'] = $this->expenses->dashboardData($user_id, $company_id, 3);
        $data['closed'] = $this->expenses->dashboardData($user_id, $company_id, 4);

        return view('home', $data);
    }
}
