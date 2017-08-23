<?php

namespace App;

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
    	return $this->belongsTo('\App\Country');
    }

    public function state()
    {
    	return $this->belongsTo('\App\State');
    }

    public function city()
    {
    	return $this->belongsTo('\App\City');
    }

    public function department()
    {
    	return $this->belongsTo('\App\Department');
    }

    public function division()
    {
    	return $this->belongsTo('\App\Division');
    }

    public function getEmployees($page=5)
    {
    	$employees = DB::table('employees')
            ->leftJoin('city', 'employees.city_id', '=', 'city.id')
            ->leftJoin('department', 'employees.department_id', '=', 'department.id')
            ->leftJoin('state', 'employees.state_id', '=', 'state.id')
            ->leftJoin('country', 'employees.country_id', '=', 'country.id')
            ->leftJoin('division', 'employees.division_id', '=', 'division.id')
            ->select('employees.*', 'department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id')
            ->paginate($page);

        return $employees;
    }

    public function addEmployee($input=[])
    {
        if (empty($input)) return 0;

		$employee                 = new Employee;
		$employee->firstname      = $input->firstname;
		$employee->lastname       = $input->lastname;
		$employee->address        = $input->address;
		$employee->country_id     = $input->country_id;
		$employee->state_id       = $input->state_id;
		$employee->city_id        = $input->city_id;
		$employee->department_id  = $input->department_id;
		$employee->division_id    = $input->division_id;
		$employee->age            = $input->age;
		$employee->birth          = $input->birth;
		$employee->date_hired     = $input->date_hired;
		$employee->avatar    	  = $input->avatar;

		if (isset($input->zip) && !empty($input->zip)) {
			$employee->zip    	  = $input->zip;
		}

		if (isset($input->employee) && !empty($input->employee)) {
            $employee->middlename = $input->middlename;
        }

        $employee->save();
        return $employee->id;
    }

    public function getEmployeeInfo($id=0)
    {
        $data = [];
        if (empty($id)) return $data;

        try
        {
            $data = $this->findOrFail($id);

            return $data->toArray();
        }
        catch(ModelNotFoundException $e)
        {
            return $data;
        }

        return $data;
    }

    public function updateEmployee($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;

        $employee                     = null;
        try
        {
            $employee       		  = $this->findOrFail($id);
            $employee->firstname      = $input->firstname;
			$employee->lastname       = $input->lastname;
			$employee->address        = $input->address;
			$employee->country_id     = $input->country_id;
			$employee->state_id       = $input->state_id;
			$employee->city_id        = $input->city_id;
			$employee->department_id  = $input->department_id;
			$employee->division_id    = $input->division_id;
			$employee->age            = $input->age;
			$employee->birth          = $input->birth;
			$employee->date_hired     = $input->date_hired;

			if (isset($input->avatar) & !empty($input->avatar)) {
				$employee->avatar     = $input->avatar;
			}

            if (isset($input->middlename) & !empty($input->middlename)) {
                $employee->middlename = $input->middlename;
            }

			if (isset($input->zip) & !empty($input->zip)) {
				$employee->zip        = $input->zip;
			}

	        $employee->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $employee->id;
    }

    public function deleteEmployee($id=0)
    {
        if (empty($id)) return 0;
        $this->where('id', $id)
            ->delete();
        return 1;
    }

    public function getSearchingQuery($constraints=[], $limit=5)
    {
        if (empty($constraints)) return null;
        
        $query = DB::table('employees')
	        ->leftJoin('city', 'employees.city_id', '=', 'city.id')
	        ->leftJoin('department', 'employees.department_id', '=', 'department.id')
	        ->leftJoin('state', 'employees.state_id', '=', 'state.id')
	        ->leftJoin('country', 'employees.country_id', '=', 'country.id')
	        ->leftJoin('division', 'employees.division_id', '=', 'division.id')
	        ->select('employees.firstname as employee_name', 'employees.*','department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate($limit);
    }

    public function getHiredEmployees($constraints=[])
    {
        if (empty($constraints)) return [];
        $employees = Employee::where('date_hired', '>=', $constraints['from'])
            ->where('date_hired', '<=', $constraints['to'])
            ->get();
        return $employees;
    }

    public function getExportingData($constraints) {
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
