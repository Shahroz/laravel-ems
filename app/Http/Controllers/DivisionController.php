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
        return view('system.division.index', [
            'divisions' => $divisions
        ]);
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
        $input  = $request->except(['_method', '_token']);
        $this->division->addDivision($input);
        return redirect()->intended('system-management/division');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Division $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $id)
    {
        $divisionInfo = $this->division
            ->getDivisionInfo($id);
        // Redirect to division list if updating division wasn't existed
        if (empty($divisionInfo)) {
            return redirect()->intended('/system-management/division');
        }

        return view('system.division.edit', [
            'division' => $divisionInfo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionFormRequest $request, Division $id)
    {
        $input  = $request->except(['_method', '_token']);
        $this->division->updateDivision($id, $input);
        return redirect()->intended('system-management/division');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DivisionFormRequest $request, Division $id)
    {
        $this->division
            ->deleteDivision('id', $id);
        return redirect()->intended('system-management/division');
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
