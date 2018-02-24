<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'divisions';

    protected $fillable = [
        'name'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [
        'id'
    ];
}
