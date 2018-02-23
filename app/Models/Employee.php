<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'firstname', 'middlename', 'lastname', 'address', 'country_id', 'state_id', 'city',
        'age', 'birth', 'date_hired', 'department_id', 'division_id', 'avatar'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [
        'id'
    ];

    public function country()
    {
    	return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state()
    {
    	return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function department()
    {
    	return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function division()
    {
    	return $this->belongsTo(Division::class, 'division_id', 'id');
    }
}
