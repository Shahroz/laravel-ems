<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository extends AbstractRepository
{
    protected $model;

    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    public function getAll($filters = [], $limit = 20)
    {
        $query = $this->model;
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (!empty($value)) {
                    $query = $query->where($key, 'like', "%{$value}%");
                }
            }
        }

        return $query->paginate($limit);
    }

    public function getCountryList()
    {
        return $this->model->pluck('name', 'id');
    }

    public function create($data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to create new country'
        ];

        try {
            $country = $this->model->create($data);

            $response['status']  = 1;
            $response['message'] = 'Country created successfully';
            $response['data']    = $country;
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(Country $country, $data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update country'
        ];

        try {
            $this->model = $country;
            $this->model->update($data);

            $response['status']  = 1;
            $response['message'] = 'Country updated successfully';
            $response['data']    = $this->model->toArray();
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function delete(Country $country)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to delete country'
        ];

        try {
            $this->model = $country;
            $this->model->delete();

            $response['status']  = 1;
            $response['message'] = 'Country deleted successfully';
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }
}
