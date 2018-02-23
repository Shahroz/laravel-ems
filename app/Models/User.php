<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
