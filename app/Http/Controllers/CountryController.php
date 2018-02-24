<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Http\Requests\CountryFormRequest;

class CountryController extends Controller
{
    protected $countryService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CountryService $countryService)
    {
        $this->middleware('auth');
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->countryService->getAll();

        return view('system.country.index', compact('countries'));
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
        $response = $this->countryService->create($request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.countries.index')
            ->with('response', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return view('system.country.edit', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('system.country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(CountryFormRequest $request, Country $country)
    {
        $response = $this->countryService->update($country, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.countries.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $response = $this->countryService->delete($country, $request);
        if (!$response['status']) {
            return redirect()->back()
                ->with('response', $response);
        }

        return redirect()->route('system.countries.index')
            ->with('response', $response);
    }

    /**
     * Search country from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = [
            'name'         => $request->get('name'),
            'country_code' => $request->get('country_code')
        ];
        $countries = $this->countryService->getAll($filters);

        return view('system.countries.index', [
            'countries'     => $countries,
            'searchingVals' => $filters
        ]);
    }
}
