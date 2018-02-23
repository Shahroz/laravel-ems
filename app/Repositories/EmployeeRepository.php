<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository extends AbstractRepository
{
    public $model;

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function getAll($filters = [], $limit = 20)
    {
        $query = $this->model;
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (!is_null($key) && !empty($value)) {
                    $query = $query->where($key, 'like', "%{$value}%");
                }
            }

            $query->with('department', 'state', 'country', 'division');
        }

        return $query->paginate($limit);
    }

    public function create($data = [])
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while creating new employee'
        ];

        try {
            $response['status']  = 1;
            $response['message'] = 'Employee created successfully!';
            $response['data']    = $this->model->create($data);
        } catch (\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(Employee $employee, $data = [])
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while updating employee'
        ];

        try
        {
            $this->model = $employee;
            $this->model->update($input);

            $response['status']  = 1;
            $response['message'] = 'Record updated successfully!'; 
        } catch(\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }

    public function delete(Employee $employee)
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while deleting employee'
        ];

        try
        {
            $this->model = $employee;
            $this->model->delete();
            $response['status']  = 1;
            $response['message'] = 'Record deleted successfully!'; 
        } catch(\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }

    public function getHiredEmployees($filters)
    {
        $employees = $this->model->where('date_hired', '>=', $filters['from'])
            ->where('date_hired', '<=', $filters['to'])
            ->get();

        return $employees;
    }

    public function getExportingData($filters)
    {
        return $this->model
            ->where('date_hired', '>=', $filters['from'])
            ->where('date_hired', '<=', $filters['to'])
            ->with('department', 'state', 'country', 'division')
            ->get()
            ->map(function ($item, $key) {
                return $item->toArray();
            })->all();
    }
}
