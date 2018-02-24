<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StateFormRequest;
use App\Services\{CountryService, StateService};

class StateController extends Controller
{
    protected $countryService;
    protected $stateService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CountryService $countryService, StateService $stateService)
    {
        $this->middleware('auth');
        $this->stateService   = $stateService;
        $this->countryService = $countryService;    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $states = $this->stateService->getAll();

        return view('system.state.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->getCountries();

        return view('system.state.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateFormRequest $request)
    {
        $response = $this->stateService->create($input);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.states.index')
            ->with('response', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(State $id)
    {
        $countries = $this->getCountries();

        return view('system.state.edit', compact(
            'countries',
            'state'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $countries = $this->getCountries();

        return view('system.state.edit', compact(
            'countries',
            'state'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(StateFormRequest $request, State $state)
    {
        $response = $this->stateService->update($state, $input);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.states.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(StateFormRequest $request, State $state)
    {
        $response = $this->stateService->delete($state);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.states.index')
            ->with('response', $response);
    }

    /**
     * Search state from database base on some specific filters
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $filters = [
            'name' => $request->get('name')
        ];

        $states = $this->stateService->getAll($filters);

        return view('system.state.index', [
            'states'        => $states, 
            'searchingVals' => $filters
        ]);
    }

    private function getCountries()
    {
        return $this->countryService->getAll();
    }
}
