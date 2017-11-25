<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['remember_token', 'id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes must be filled.
     *
     * @var array
     */
    protected $filllable = [
        'username', 'email', 'first_name', 'last_name'
    ];

    /**
     * Get pagination users list
     *
     * @param int $limit
     * @return array
     **/
    public function getUserList($limit = 5)
    {
        return $this->paginate($limit);
    }

    /**
     * Get user info
     * @param null $id
     * @param array $fields
     * @return array
     */
    public function getUserInfo($id = null, $fields = [])
    {
        $data = [];
        try
        {
            $user = $this->findOrFail($id);
            if (!empty($fields)) {
                $data = $user->get($fields)
                    ->toArray();
            } else {
                $data = $user->toArray();
            }
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    /**
     * Add new user
     * @param array $input
     * @return int
     */
    public function addUser($input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        return $this->create($input);
    }

    /**
     * Update user by id
     * @param null $id
     * @param array $input
     * @return int
     */
    public function updateUser($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try
        {
            $user     = $this->findOrFail($id);
            if (isset($input->password) && strlen($input->password) >= 8) {
                $input['password'] =  bcrypt($input->password);
            }

            $user->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    /**
     * Remove user
     * @param null $id
     * @return int
     */
    public function deleteUser($id = null)
    {
        $status = 0;
        try
        {
            $user = $this->findOrFail($id);
            $user->delete();
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    public function getSearchingQuery($constraints = [], $limit = 5)
    {
        if (empty($constraints)) {
            return null;
        }

        $query  = $this->query();
        $fields = array_keys($constraints);
        $index  = 0;
        foreach ($constraints as $constraint) {
            if (!is_null($constraint)) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        
        return $query->paginate($limit);
    }
}
