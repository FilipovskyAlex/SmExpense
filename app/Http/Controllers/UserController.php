<?php

namespace App\Http\Controllers;

use App\Category;
use App\Company;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\UserRequest;
use App\User;
use App\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $data['users'] = $this->users->getUsersById();

        return view('users.index', $data);
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

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $validated = $request->all();

        $this->users->parent_id = Auth::user()->id;
        $this->users->name = $validated['name'];
        $this->users->email = $validated['email'];
        $this->users->password = Hash::make($validated['password']);
        $this->users->phone = $validated['phone'];
        $this->users->company_id = $validated['company_id'];
        $this->users->company_name = $validated['company_name'];
        $this->users->country = $validated['country'];
        $this->users->state = $validated['state'];
        $this->users->city = $validated['city'];
        $this->users->address = $validated['address'];
        $this->users->post_code = $validated['post_code'];
        $this->users->status = $validated['status'];
        $this->users->role = $validated['role'];

        $this->users->save();

        if(count($validated['access']) > 0) {
            $user_id = $this->users->id;

            foreach ($validated['access'] as $company_id => $category) {
                if(is_array($category)) {
                    if(isset($category)) {
                        foreach ($category as $cat) {
                            $userDetailData['user_id'] = $user_id;
                            $userDetailData['company_id'] = $company_id;
                            $userDetailData['category_id'] = $cat;

                            $user_detail = new UserDetails($userDetailData);

                            $user_detail->save();
                        }
                    }
                } else {
                    $userDetailData['user_id'] = $user_id;
                    $userDetailData['company_id'] = $company_id;
                    $userDetailData['category_id'] = null;

                    $user_detail = new UserDetails($userDetailData);

                    $user_detail->save();
                }
            }
        }

        return redirect()->route('users.index')->with('message', 'New user record has been inserted!');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $data['roles'] = $this->users->roles();
        $data['companies'] = $this->companies->getCompaniesByUser();
        $data['categories'] = $this->categories->getCategoriesByUser();
        $data['user'] = $this->users->getUsersById($id);
        $data['user'] = $data['user'][0];

        return view('users.edit', $data);
    }

    /**
     * @param EditUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(EditUserRequest $request, int $id)
    {
        $validated = $request->all();

        $user = $this->users->find($id);

        // If user has changed his email we should validate it
        if($validated['email'] != $user->email) {
            $this->validate($request, [
                'email' => 'required|unique:users'
            ]);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->company_id = $validated['company_id'];
        $user->company_name = $validated['company_name'];
        $user->country = $validated['country'];
        $user->state = $validated['state'];
        $user->city = $validated['city'];
        $user->address = $validated['address'];
        $user->post_code = $validated['post_code'];
        $user->status = $validated['status'];
        $user->role = $validated['role'];

        $user->save();

        // Flush all the records where id is equal to user_id
        UserDetails::where('user_id', $id)->delete();

        if(count($validated['access']) > 0) {
            $user_id = $user->id;

            foreach ($validated['access'] as $company_id => $category) {
                if(is_array($category)) {
                    if(isset($category)) {
                        foreach ($category as $cat) {
                            $userDetailData['user_id'] = $user_id;
                            $userDetailData['company_id'] = $company_id;
                            $userDetailData['category_id'] = $cat;

                            $user_detail = new UserDetails($userDetailData);

                            $user_detail->save();
                        }
                    }
                } else {
                    $userDetailData['user_id'] = $user_id;
                    $userDetailData['company_id'] = $company_id;
                    $userDetailData['category_id'] = null;

                    $user_detail = new UserDetails($userDetailData);

                    $user_detail->save();
                }
            }
        }

        return redirect()->route('users.index')->with('message', 'User record has been updated!');
    }

    public function delete()
    {

    }
}
