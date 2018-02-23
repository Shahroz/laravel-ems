<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Country, State};
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
        $input  = $request->except(['_token', '_method', 'id']); 
        $status = (new State)->addState($input);

        return redirect()->route('system.states.index');
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
        $input  = $request->except(['_token', '_method', 'id']);
        $state->update($input);

        return redirect()->route('system.states.index');
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
        $state->delete();

        return redirect()->route('system.states.index');
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
