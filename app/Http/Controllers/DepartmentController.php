<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\department;

class DepartmentController extends Controller
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
        $departments = (new Department)->getDepartments();
        return view('system.department.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\DepartmentFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentFormRequest $request)
    {
        $department = (new Department)->addDepartment((object)$request->input());
        return redirect()->intended('system-management/department');
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
        $department = (new Department)->getDepartmentInfo($id);
        // Redirect to department list if updating department wasn't existed
        if (empty($department)) {
            return redirect()->intended('/system-management/department');
        }

        return view('system.department.edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentFormRequest $request, $id)
    {
        $status = (new Department)->updateDepartment($id, (object)$request->input());
        return redirect()->intended('system-management/department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentFormRequest $request, $id)
    {
        $status = (new Department)->deleteDepartment('id', $id);
        return redirect()->intended('system-management/department');
    }

    /**
     * Search department from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request->get('name')
        ];

       $departments = (new Department)->getSearchingQuery($constraints);
       return view('system.department.index', [
            'departments'   => $departments, 
            'searchingVals' => $constraints
        ]);
    }
}
