<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DepartmentService;
use App\Http\Requests\DepartmentFormRequest;

class DepartmentController extends Controller
{
    protected $departmentService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DepartmentService $departmentService)
    {
        $this->middleware('auth');
        $this->departmentService = $departmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = $this->departmentService->getAll();

        return view('system.department.index', compact('departments'));
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
        $response = $this->departmentService->create($request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.departments.index')
            ->with('response', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return view('system.department.edit', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('system.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentFormRequest $request, Department $department)
    {
        $response = $this->departmentService->update($department, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.departments.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.

     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentFormRequest $request, Department $department)
    {
        $response = $this->departmentService->delete($department, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.departments.index')
            ->with('response', $response);
    }

    /**
     * Search department from database base on some specific filters
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = [
            'name' => $request->get('name')
        ];

       $departments = $this->departmentService->getAll($filters);

       return view('system.department.index', [
            'departments'   => $departments,
            'searchingVals' => $filters
        ]);
    }
}
