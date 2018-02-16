<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StateFormRequest;

class StateController extends Controller
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
        $states = (new State)->getStateList();
        return view('system.state.index', [
            'states' => $states
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->getCountries();
        return view('system.state.create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateFormRequest $request)
    {
        $input  = $request->except(['_token', '_method']); 
        $status = (new State)->addState($input);
        return redirect()->intended('system-management/state');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(State $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $id)
    {
        $state = (new State)->getStateInfo($id);
        // Redirect to state list if updating state wasn't existed
        if (empty($state)) {
            return redirect()->intended('/system-management/state');
        }

        $countries = $this->getCountries();
        return view('system.state.edit', [
            'state'     => $state, 
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateFormRequest $request, State $id)
    {
        $input  = $request->except(['_token', '_method']);
        $status = (new State)->updateState($id, $input);
        return redirect()->intended('system-management/state');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\StateFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StateFormRequest $request, State $id)
    {
        $status = (new State)->deleteState($id);
        return redirect()->intended('system-management/state');
    }

    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request['name']
        ];

        $states = (new State)->getSearchingQuery($constraints);
        return view('system.state.index', [
            'states'        => $states, 
            'searchingVals' => $constraints
        ]);
    }

    private function getCountries()
    {
        $countries = (new Country)->getAllCountries();
        return $countries;
    }
}