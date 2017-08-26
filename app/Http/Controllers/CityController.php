<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CityFormRequest;
use Illuminate\Support\Facades\DB;
use App\City;
use App\State;

class CityController extends Controller
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
        $cities = (new City)->getCities();
        return view('system.city.index', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = $this->getStates();
        return view('system.city.create', ['states' => $states]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityFormRequest $request)
    {
        $id = (new City)->addCity((object)$request->input());
        return redirect()->intended('system.city');
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
        $city = (new City)->getCityInfo($id);
        // Redirect to city list if updating city wasn't existed
        if (empty($city)) {
            return redirect()->intended('/system-management/city');
        }

        $states = $this->getStates();
        return view('system.city.edit', ['city' => (object) $city, 'states' => $states]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityFormRequest $request, $id)
    {
        $city = (new City)->updateCity($id, (object)$request->input());
        return redirect()->intended('system-management/city');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\CityFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityFormRequest $request, $id)
    {
        $id = (new City)->deleteCity($id);
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

       $cities = (new City)->getSearchingQuery($constraints);
       return view('system.city.index', ['cities' => $cities, 'searchingVals' => $constraints]);
    }

    private function getStates()
    {
        return (new State)->getAllStates();
    }
}
