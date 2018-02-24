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
}
