<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{
    public $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAll($filters = [], $limit = 20)
    {
        $query = $this->model;
        foreach ($filters as $key => $value) {
            if (!is_null($value)) {
                $query = $query->whereRaw("LOWER(`{$key}`) LIKE ?", "%{$value}%");
            }
        }

        return $query->paginate($limit);
    }

    public function create($data = [])
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while creating new user'
        ];

        try {
            $response['status']  = 1;
            $response['message'] = 'User created successfully!';
            $response['data']    = $this->model->create($data);
        } catch (\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }

    public function update(User $user, $data = [])
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while updating user'
        ];

        try
        {
            $this->model = $user;
            if (isset($data['password']) && strlen($data['password']) >= 8) {
                $data['password'] =  bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $this->model->update($data);
            $response['status']  = 1;
            $response['message'] = 'Record updated successfully!'; 
        } catch(\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }


        return $response;
    }

    public function delete(User $user)
    {
        $response = [
            'status'  => 0,
            'message' => 'An error occurred while deleting user'
        ];

        try
        {
            $this->model = $user;
            $this->model->delete();
            $response['status']  = 1;
            $response['message'] = 'Record deleted successfully!'; 
        } catch(\Exception $ex) {
            $response['error'] = $ex->getMessage();
        }

        return $response;
    }
}
