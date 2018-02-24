<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Repositories\CountryRepository;

class CountryService
{
    protected $countryRepository;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAll($filters = [])
    {
        return $this->countryRepository->getAll($filters);
    }

    public function getCountryList()
    {
        return $this->countryRepository->getCountryList();
    }

    public function create(Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->countryRepository->create($input);
    }

    public function update(Country $country, Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->countryRepository->update($country, $input);
    }

    public function delete(Country $country)
    {
        return $this->countryRepository->delete($country);
    }
}
