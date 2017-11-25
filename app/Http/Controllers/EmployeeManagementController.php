<?php

namespace App\Http\Controllers;

use Response;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeFormRequest;

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
        return view('employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->getFormData();
        return view('employees.create', $data);
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
        $input           = $request->except(['_method', '_token']);
        $input['avatar'] = $path;

        $id = (new Employee)->addEmployee($input);
        return redirect()->intended('/employee-management');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $id)
    {
        $employee = (new Employee)->getEmployeeInfo($id);
        // Redirect to state list if updating state wasn't existed
        if (empty($employee)) {
            return redirect()->intended('/employee-management');
        }

        $data             = $this->getFormData();
        $data['employee'] = $employee; 
        return view('employees.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $id)
    {
        $input = $request->except(['_method', '_token']);
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $input['avatar'] = $path;
        }

        $status = (new Employee)->updateEmployee($id, $input);
        return redirect()->intended('/employee-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeFormRequest $request, Employee $id)
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
    public function search(Request $request)
    {
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
    public function load($name)
    {
        if (!empty($name)) {
            $path = storage_path().'/app/avatars/'.$name;
            if (file_exists($path)) {
                return response()->download($path);
            }
        }

        return $name;
    }

    private function getFormData()
    {
        $data = [
            'cities'      => (new City)->getAllCities(),
            'states'      => (new State)->getAllStates(),
            'countries'   => (new Country)->getAllCountries(),
            'departments' => (new Department)->getAllDepartments(),
            'divisions'   => (new Division)->getAllDivisions()
        ];

        return $data;
    }
}
