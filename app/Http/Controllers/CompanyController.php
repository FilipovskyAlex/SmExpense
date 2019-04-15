<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\StoreCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * CompanyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show a list of current user companies
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('companies.index');
    }

    /**
     * Create new company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // add H1 header
        $data['companyTitle'] = trans('app.companies-create');

        return view('companies.create', $data);
    }

    /**
     * Store new company
     * @param StoreCompany $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompany $request)
    {
        // Validate request company data
        $company = new Company($request->all());

        // Store company to a database dynamically with current user_id and creating company form data
        Auth::user()->companies()->save($company);

        return redirect()->back()->with('message', 'New company is created');
    }
}
