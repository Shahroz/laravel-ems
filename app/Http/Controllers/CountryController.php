<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CountryFormRequest;
use Illuminate\Support\Facades\DB;
use App\Country;

class CountryController extends Controller
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
        $countries = (new Country)->getCountries();

        return view('system.country.index', ['countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryFormRequest $request)
    {
        $id = (new Country)->addCountry((object)$request->input());
        return redirect()->intended('system-management/country');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = (new Country)->getCountryInfo($id);
        // Redirect to country list if updating country wasn't existed
        if (empty($country)) {
            return redirect()->intended('/system-management/country');
        }

        return view('system.country.edit', ['country' => $country]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = (new Country)->getCountryInfo($id);
        // Redirect to country list if updating country wasn't existed
        if (empty($country)) {
            return redirect()->intended('/system-management/country');
        }

        return view('system.country.edit', ['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryFormRequest $request, $id)
    {
        $status = (new Country)->updateCountry($id, $request->input());
        return redirect()->intended('system-management/country');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CountryFormRequest $request, $id)
    {
        $status = (new Country)->deleteCountry($id);
        return redirect()->intended('system-management/country');
    }

    /**
     * Search country from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'name'         => $request->get('name'),
            'country_code' => $request->get('country_code')
        ];

       $countries = (new Country)->getSearchingQuery($constraints);
       return view('system.country.index', [
            'countries'     => $countries, 
            'searchingVals' => $constraints
        ]);
    }
}
