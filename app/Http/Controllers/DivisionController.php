<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Division;

class DivisionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = (new Division)->getDivisions();
        return view('system.division.index', ['divisions' => $divisions]);
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
        $id = (new Division)->addDivision((object)$request->input());
        return redirect()->intended('system-management/division');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $division = (new Division)->getDivisionInfo($id);
        // Redirect to division list if updating division wasn't existed
        if (empty($division)) {
            return redirect()->intended('/system-management/division');
        }

        return view('system.division.edit', ['division' => $division]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionFormRequest $request, $id)
    {
        $status = (new Division)->updateDivision($id, (object)$request->input());
        return redirect()->intended('system-management/division');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DivisionFormRequest $request, $id)
    {
        $status = (new Division)->deleteDivision('id', $id);
        return redirect()->intended('system-management/division');
    }

    /**
     * Search division from database base on some specific constraints
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
        ];

       $divisions = (new Division)->getSearchingQuery($constraints);
       return view('system.division.index', [
            'divisions'     => $divisions, 
            'searchingVals' => $constraints
        ]);
    }
}
