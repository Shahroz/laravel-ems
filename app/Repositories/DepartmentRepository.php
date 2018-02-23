<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends AbstractRepository
{
    protected $model;

    public function __construct(Department $department)
    {
        $this->model = $department;
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
            'message' => 'Unable to create new department'
        ];

        try {
            $department = $this->model->create($data);

            $response['status']  = 1;
            $response['message'] = 'Department created successfully';
            $response['data']    = $department;
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(Department $department, $data)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update new department'
        ];

        try {
            $this->model = $department;
            $this->model->update($data);

            $response['status']  = 1;
            $response['message'] = 'Department updated successfully';
            $response['data']    = $this->model->toArray();
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }

    public function delete(Department $department)
    {
        $response = [
            'status'  => 0,
            'message' => 'Unable to update new department'
        ];

        try {
            $this->model = $department;
            $this->model->delete();

            $response['status']  = 1;
            $response['message'] = 'Department deleted successfully';
        } catch(\Exception $ex) {
            $response['message'] = $ex->getMessage();
        }

        return $response;
    }
}
