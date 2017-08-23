<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Employee;
use App\City;
use App\State;
use App\Country;
use App\Department;
use App\Division;

class EmployeeManagementController extends Controller
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
        $employees = (new Employee)->getEmployees();
        return view('employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities      = (new City)->getAllCities();
        $states      = (new State)->getAllStates();
        $countries   = (new Country)->getAllCountries();
        $departments = (new Department)->getAllDepartments();
        $divisions   = (new Division)->getAllDivisions();
        return view('employees.create', [
            'cities'      => $cities, 
            'states'      => $states, 
            'countries'   => $countries,
            'departments' => $departments, 
            'divisions'   => $divisions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeFormRequest $request)
    {
        // Upload image
        $path            = $request->file('avatar')->store('avatars');
        $input           = $request->input();
        $input['avatar'] = $path;

        $id = (new Employee)->addEmployee((object)$input);
        return redirect()->intended('/employee-management');
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
        $employee = (new Employee)->getEmployeeInfo($id);
        // Redirect to state list if updating state wasn't existed
        if (empty($employee)) {
            return redirect()->intended('/employee-management');
        }

        $cities      = (new City)->getAllCities();
        $states      = (new State)->getAllStates();
        $countries   = (new Country)->getAllCountries();
        $departments = (new Department)->getAllDepartments();
        $divisions   = (new Division)->getAllDivisions();
        return view('employees.edit', [
            'employee'    => $employee, 
            'cities'      => $cities,
            'states'      => $states, 
            'countries'   => $countries,
            'departments' => $departments, 
            'divisions'   => $divisions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, $id)
    {
        $input = $request->input();
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $input['avatar'] = $path;
        }

        $status = (new Employee)->updateEmployee($id, (object)$input);
        return redirect()->intended('/employee-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeFormRequest $request, $id)
    {
        $status = (new Employee)->deleteEmployee($id);
        return redirect()->intended('/employee-management');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'firstname'       => $request->get('firstname'),
            'department.name' => $request->get('department_name')
        ];
        $employees = (new Employee)->getSearchingQuery($constraints);
        $constraints['department_name'] = $request['department_name'];
        
        return view('employees.index', [
            'employees'     => $employees, 
            'searchingVals' => $constraints
        ]);
    }

     /**
     * Load image resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function load($name) {
        $path = storage_path().'/app/avatars/'.$name;
        if (file_exists($path)) {
            return Response::download($path);
        }
    }
}
