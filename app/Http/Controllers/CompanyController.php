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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('companies.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['companyTitle'] = trans('app.companies-create');

        return view('companies.create', $data);
    }

    /**
     * @param StoreCompany $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompany $request)
    {
        $validated = $request->validated();

        $company = new Company();

        $company->name = $validated['name'];
        $company->user_id = Auth::user()->id;

        $company->save();

        return redirect()->back()->with('message', 'New company is created');
    }
}
