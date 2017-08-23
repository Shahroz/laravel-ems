<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['remember_token'];

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
    public function getUserList($limit=5)
    {
        return $this->paginate($limit);
    }

    /**
     * @param int $id
     * @param array $fields
     * @return array
     */
    public function getUserInfo($id=0, $fields=[])
    {
        $data = [];
        if (empty($id)) return $data;

        try
        {
            $data = $this->findOrFail($id);

            if (!empty($fields)) {
                return $data->get($fields)
                    ->toArray();
            }
            return $data->toArray();
        }
        catch(ModelNotFoundException $e)
        {
            $data = [];
        }

        return $data;
    }


    /**
     * @param array $input
     * @return mixed
     */
    public function addUser($input=[])
    {
        if (empty($input)) 0;

        $user             = new User;
        $user->username   = $input->username;
        $user->email      = $input->email;
        $user->first_name = $input->first_name;
        $user->last_name  = $input->last_name;
        $user->password   = $input->password;
        $user->save();

        return $user->id;
    }

    /**
     * @param int $id
     * @param array $input
     * @return int
     */
    public function updateUser($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;

        try
        {
            $user               = $this->findOrFail($id);
            $user->username     = $input->username;
            $user->first_name   = $input->first_name;
            $user->last_name    = $input->last_name;
            $user->email        = $input->email;

            if (isset($input->password) && strlen($input->password) > 0) {
                $user->password =  bcrypt($input->password);
            }
            $user->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $user->id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteUser($id=0)
    {
        if (empty($id)) return 0;
        $this->where('id', $id)
            ->delete();
        return 1;
    }

    public function getSearchingQuery($constraints=[], $limit=5)
    {
        if (empty($constraints)) return null;
        $query  = $this->query();
        $fields = array_keys($constraints);
        $index  = 0;
        foreach ($constraints as $constraint) {
            if (!in_null($constraint)) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate($limit);
    }
}
