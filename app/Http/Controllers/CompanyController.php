<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function index()
    {
        return view('companies.index');
    }

    public function create()
    {
        $data['companyTitle'] = trans('app.companies-create');

        return view('companies.create', $data);
    }

    public function store()
    {

    }
}
