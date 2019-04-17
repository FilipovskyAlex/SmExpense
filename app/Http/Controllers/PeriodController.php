<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodStore;
use App\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class PeriodController
 * @package App\Http\Controllers
 */
class PeriodController extends Controller
{
    /**
     * PeriodController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->period = new Period();
    }

    public function create()
    {

    }

    public function update(int $id)
    {

    }

    public function edit(int $id)
    {

    }

    /**
     * @param PeriodStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PeriodStore $request) : RedirectResponse
    {
        $period = new Period($request->all());

        $period->save();

        return redirect()->back()->with('message', 'New period is created');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id) : RedirectResponse
    {
        $period = $this->period::findOrFail($id);

        $period->delete();

        return redirect()->back()->with('message', 'Period was deleted');
    }
}
