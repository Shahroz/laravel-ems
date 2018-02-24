<?php

namespace App\Repositories;

use App\Models\Division;

class DivisionRepository extends AbstractRepository
{
    protected $model;

    public function __construct(Division $division)
    {
        $this->model = $division;
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

    public function create($data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to create new division'
        ];

        try {
            $division = $this->model->create($data);

            $response['status']  = 1;
            $response['message'] = 'Division created successfully';
            $response['data']    = $division;
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(Division $division, $data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update division'
        ];

        try {
            $this->model = $division;
            $this->model->update($data);

            $response['status']  = 1;
            $response['message'] = 'Division updated successfully';
            $response['data']    = $this->model->toArray();
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function delete(Division $division)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to delete division'
        ];

        try {
            $this->model = $division;
            $this->model->delete();

            $response['status']  = 1;
            $response['message'] = 'Division deleted successfully';
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }
}
