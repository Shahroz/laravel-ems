<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeeFormRequest;
use App\Services\{EmployeeService, DepartmentService, DivisionService, CountryService, StateService};

class EmployeeManagementController extends Controller
{
    /**
     * Instance of Services.
     */
    protected $stateService;
    protected $countryService;
    protected $employeeService;
    protected $divisionService;
    protected $departmetService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EmployeeService $employeeService,
        DepartmentService $departmetService,
        DivisionService $divisionService,
        CountryService $countryService,
        StateService $stateService
    )
    {
        $this->middleware('auth');
        $this->stateService     = $stateService;
        $this->countryService   = $countryService;
        $this->employeeService  = $employeeService;
        $this->divisionService  = $divisionService;
        $this->departmetService = $departmetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = $this->employeeService->getAll($request);
        
        return view('employees.index', compact('employees'));
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
        $response = $this->employeeService->create($input);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('employee.index')
            ->with('response', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $data             = $this->getFormData();
        $data['employee'] = $employee; 

        return view('employees.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $data             = $this->getFormData();
        $data['employee'] = $employee; 

        return view('employees.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $response = $this->employeeService->update($employee, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('employee.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\EmployeeFormRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeFormRequest $request, Employee $employee)
    {
        $response = $this->employeeService->delete($employee, $request);

        return redirect()->route('employee.index')
            ->with('response', $response);
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
        $employees = $this->employeeService->getAll($constraints);
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
            'states'      => $this->stateService->getAll(),
            'countries'   => $this->countryService->getAll(),
            'departments' => $this->departmetService->getAll(),
            'divisions'   => $this->divisionService->getAll()
        ];

        return $data;
    }
}
