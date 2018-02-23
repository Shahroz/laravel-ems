<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DivisionFormRequest;

class DivisionController extends Controller
{
    private $division;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->division = new Division;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = $this->division
            ->getDivisions();

        return view('system.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.division.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionFormRequest $request)
    {
        $input  = $request->except(['_method', '_token', 'id']);
        $this->division->addDivision($input);

        return redirect()->route('system.divisions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
        return view('system.division.edit', compact('division'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return view('system.division.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionFormRequest $request, Division $division)
    {
        $input  = $request->except(['_method', '_token', 'id']);
        $division->update($input);

        return redirect()->route('system.divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(DivisionFormRequest $request, Division $division)
    {
        $division->delete();

        return redirect()->route('system.divisions.index');
    }

    /**
     * Search division from database base on some specific constraints
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $constraints = [
            'name' => $request['name']
        ];
        $divisions = $this->division
            ->getSearchingQuery($constraints);

        return view('system.division.index', [
            'divisions'     => $divisions,
            'searchingVals' => $constraints
        ]);
    }
}
