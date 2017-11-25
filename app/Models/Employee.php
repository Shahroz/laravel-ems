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
        'firstname', 'lastname', 'address', 'country_id', 'state_id', 'city_id',
        'age', 'birth', 'date_hired', 'department_id', 'division_id'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    public function country()
    {
    	return $this->belongsTo('\App\Country', 'country_id', 'id');
    }

    public function state()
    {
    	return $this->belongsTo('\App\State', 'state_id', 'id');
    }

    public function city()
    {
    	return $this->belongsTo('\App\City', 'city_id', 'id');
    }

    public function department()
    {
    	return $this->belongsTo('\App\Department', 'department_id', 'id');
    }

    public function division()
    {
    	return $this->belongsTo('\App\Division', 'division_id', 'id');
    }

    public function getEmployees($page = 5)
    {
    	$employees = DB::table('employees')
            ->leftJoin('city', 'employees.city_id', '=', 'city.id')
            ->leftJoin('department', 'employees.department_id', '=', 'department.id')
            ->leftJoin('state', 'employees.state_id', '=', 'state.id')
            ->leftJoin('country', 'employees.country_id', '=', 'country.id')
            ->leftJoin('division', 'employees.division_id', '=', 'division.id')
            ->select(
                'employees.*',
                'department.name as department_name',
                'department.id as department_id',
                'division.name as division_name',
                'division.id as division_id'
            )
            ->paginate($page);

        return $employees;
    }

    public function addEmployee($input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        return $this->create($input);
    }

    public function getEmployeeInfo($id = null)
    {
        $data = [];
        try {
            $employee = $this->findOrFail($id);
            $data     = $employee->toArray();
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    public function updateEmployee($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try {
            $employee = $this->findOrFail($id);
            $employee->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    public function deleteEmployee($id = null)
    {
        $status = 0;
        try {
            $employee = $this->findOrFail($id);
            $employee->delete();
            $status = 1;
        } catch(ModelNotFoundException $e) {
            $status = 0;
        }

        return $status;
    }

    public function getSearchingQuery($constraints = [], $limit = 5)
    {
        if (empty($constraints)) {
            return null;
        }

        $query = DB::table('employees')
	        ->leftJoin('city', 'employees.city_id', '=', 'city.id')
	        ->leftJoin('department', 'employees.department_id', '=', 'department.id')
	        ->leftJoin('state', 'employees.state_id', '=', 'state.id')
	        ->leftJoin('country', 'employees.country_id', '=', 'country.id')
	        ->leftJoin('division', 'employees.division_id', '=', 'division.id')
	        ->select(
	            'employees.firstname as employee_name',
                'employees.*',
                'department.name as department_name',
                'department.id as department_id',
                'division.name as division_name',
                'division.id as division_id'
            );
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

    public function getHiredEmployees($constraints = [])
    {
        if (empty($constraints)) {
            return [];
        }
        
        $employees = Employee::where('date_hired', '>=', $constraints['from'])
            ->where('date_hired', '<=', $constraints['to'])
            ->get();
        return $employees;
    }

    public function getExportingData($constraints)
    {
        return DB::table('employees')
            ->leftJoin('city', 'employees.city_id', '=', 'city.id')
            ->leftJoin('department', 'employees.department_id', '=', 'department.id')
            ->leftJoin('state', 'employees.state_id', '=', 'state.id')
            ->leftJoin('country', 'employees.country_id', '=', 'country.id')
            ->leftJoin('division', 'employees.division_id', '=', 'division.id')
            ->select('employees.firstname', 'employees.middlename', 'employees.lastname',
                'employees.age','employees.birthdate', 'employees.address', 'employees.zip',
                'employees.date_hired', 'department.name as department_name',
                'division.name as division_name')
            ->where('date_hired', '>=', $constraints['from'])
            ->where('date_hired', '<=', $constraints['to'])
            ->get()
            ->map(function ($item, $key) {
                return (array) $item;
            })
            ->all();
    }
}
