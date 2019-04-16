<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\StoreCompany;
use App\Providers\CommonProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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

        $this->companies = new Company();
        $this->users = new User();
        $this->colors = CommonProvider::colors();
    }

    /**
     * Show a list of current user companies
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title'] = trans('app.companies-title');
        $data['colors'] = $this->colors;
        $data['users'] = $this->users;
        $data['companies'] = $this->companies->get();

        return view('companies.index', $data);
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

    public function active()
    {
        $user_id = Auth::user()->id;

        $company_id = Input::get('company');
        $company_id = base64_decode(urldecode($company_id));

        $company = $this->companies->find($company_id);
        $user = $this->users->find($user_id);

        $user->company_id = $company->id;
        $user->company_name = $company->name;

        $user->save();

        return redirect()->route('company.index')->with('message', $company->name.' selected');
    }
}
