<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodStore;
use App\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function update(PeriodStore $request, int $id)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $period = $this->period::findOrFail($id);

        $validated = $request->validated();

        $period->from = $validated['from'];
        $period->to = $validated['to'];

        $period->save();

        return redirect()->route('categories_periods.index')->with('message', 'Period updated successfully');
    }

    public function edit(int $id)
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $data['period'] = $this->period::findOrFail($id);

        return view('periods.edit', $data);
    }

    /**
     * @param PeriodStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PeriodStore $request) : RedirectResponse
    {
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

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
        if(Auth::user()->role == 3) {
            return redirect()->back()->with('error', 'Access denied, you do not have sufficient privilege');
        }

        $period = $this->period::findOrFail($id);

        $period->delete();

        return redirect()->back()->with('message', 'Period was deleted');
    }
}
