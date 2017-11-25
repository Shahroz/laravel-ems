<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CityFormRequest;

class CityController extends Controller
{
    private $city;
    private $state;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->state = new State;
        $this->city  = new City;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = $this->city->getCities();
        return view('system.city.index', [
            'cities' => $cities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = $this->getStates();
        return view('system.city.create', [
            'states' => $states
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityFormRequest $request)
    {
        $input  = $request->except(['_method', '_token']);
        $status = $this->city->addCity($input);
        if (empty($status)) {
            $states = $this->getStates();
            return redirect()
                ->back()
                ->withErrors(['error', 'Unable to save records. Please try again!'])
                ->with('states', $states);
        }

        return redirect()->intended('system.city');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(City $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $id)
    {
        $states = $this->getStates();
        return view('system.city.edit', [
            'city'   => (object) $city->toArray(),
            'states' => $states
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityFormRequest $request, City $id)
    {
        $input  = $request->except(['_method', '_token']);
        $status = $this->city->updateCity($id, $input);
        return redirect()->intended('system-management/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityFormRequest $request, City $id)
    {
        $this->city->deleteCity($id);
        return redirect()->intended('system-management/city');
    }

    /**
     * Search city from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name' => $request->name
        ];

       $cities = $this->city
            ->getSearchingQuery($constraints);
       return view('system.city.index', [
            'cities'        => $cities,
            'searchingVals' => $constraints
        ]);
    }

    private function getStates()
    {
        return $this->state
            ->getAllStates();
    }
}
