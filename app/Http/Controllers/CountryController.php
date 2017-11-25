<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CountryFormRequest;

class CountryController extends Controller
{
    private $country;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->country = new Country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->country
            ->getCountries();
        return view('system.country.index', [
            'countries' => $countries
        ]);
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
        $input  = $request->except(['_method', '_token']);
        $status = $this->country
            ->addCountry($input);
        return redirect()->intended('system-management/country');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $id)
    {
        $countryInfo = $this->country
            ->getCountryInfo($id);
        // Redirect to country list if updating country wasn't existed
        if (empty($countryInfo)) {
            return redirect()->intended('/system-management/country');
        }

        return view('system.country.edit', [
            'country' => $countryInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $id)
    {
        $countryInfo = $this->country
            ->getCountryInfo($id);
        // Redirect to country list if updating country wasn't existed
        if (empty($countryInfo)) {
            return redirect()->intended('/system-management/country');
        }

        return view('system.country.edit', [
            'country' => $countryInfo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryFormRequest $request, Country $id)
    {
        $input  = $request->except(['_method', '_token']);
        $status = $this->country
            ->updateCountry($id, $input);
        return redirect()->intended('system-management/country');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CountryFormRequest $request, Country $id)
    {
        $this->country
            ->deleteCountry($id);
        return redirect()->intended('system-management/country');
    }

    /**
     * Search country from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $constraints = [
            'name'         => $request->get('name'),
            'country_code' => $request->get('country_code')
        ];

       $countries = $this->country
            ->getSearchingQuery($constraints);
       return view('system.country.index', [
            'countries'     => $countries,
            'searchingVals' => $constraints
        ]);
    }
}
