<?php

namespace App\Repositories;

use App\Models\State;

class StateRepository extends AbstractRepository
{
    protected $model;

    public function __construct(State $state)
    {
        $this->model = $state;
    }

    public function getAll($filters = [])
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
            'message' => 'Unable to create new state'
        ];

        try {
            $state = $this->model->create($data);

            $response['status']  = 1;
            $response['message'] = 'State created successfully';
            $response['data']    = $state;
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(State $state, $data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update new state'
        ];

        try {
            $this->model = $state;
            $this->model->update($data);

            $response['status']  = 1;
            $response['message'] = 'State updated successfully';
            $response['data']    = $this->model->toArray();
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function delete(State $state)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update new state'
        ];

        try {
            $this->model = $state;
            $this->model->delete();

            $response['status']  = 1;
            $response['message'] = 'State deleted successfully';
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }
}
