<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->category = new Category();
    }

    public function create()
    {
        $data['create'] = trans('app.categories-create');
    }

    public function update(CategoryStore $request, int $id)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $category = $this->category::findOrFail($id);

        $validated = $request->validated();

        $category->name = $validated['name'];

        $category->save();

        return redirect()->route('categories_periods.index')->with('message', 'Category updated successfully');
    }

    public function edit(int $id)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $data['category'] = $this->category::findOrFail($id);

        return view('categories.edit', $data);
    }

    /**
     * @param CategoryStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryStore $request) : RedirectResponse
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $category = new Category($request->all());

        $category->save();

        return redirect()->back()->with('message', 'New category is created');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $category = $this->category::findOrFail($id);

        $category->delete();

        return redirect()->back()->with('message', 'Category '.$category->name.' was deleted');
    }
}
