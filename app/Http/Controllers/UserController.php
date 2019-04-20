<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->companies = new Company();
        $this->categories = new Category();
        $this->users = new User();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['roles'] = $this->users->roles();
        $data['companies'] = $this->companies->getCompaniesByUser();
        $data['categories'] = $this->categories->getCategoriesByUser();

        return view('users.create', $data);
    }

    public function store(Request $request)
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
