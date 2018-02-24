<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Services\DivisionService;
use App\Http\Requests\DivisionFormRequest;

class DivisionController extends Controller
{
    protected $divisionService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DivisionService $divisionService)
    {
        $this->middleware('auth');
        $this->divisionService = $divisionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $divisions = $this->divisionService->getAll();

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
        $response = $this->divisionService->create($request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.divisions.index')
            ->with('response', $response);
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
        $response = $this->divisionService->update($division, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.divisions.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Division $division)
    {
        $response = $this->divisionService->delete($division);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.divisions.index')
            ->with('response', $response);
    }

    /**
     * Search division from database base on some specific filters
     *
     * @param  \App\Http\Requests\DivisionFormRequest  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = [
            'name' => $request['name']
        ];
        $divisions = $this->divisionService->getAll($filters);

        return view('system.division.index', [
            'divisions'     => $divisions,
            'searchingVals' => $filters
        ]);
    }
}
