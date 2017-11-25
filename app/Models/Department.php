<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'department';

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

    public function getAllDepartments()
    {
        return $this->all();
    }

    public function getDepartments($page = 5)
    {
        return $this->paginate($page);
    }

    public function addDepartment($input = [])
    {
        if (empty($input)) {
            return 0;
        }

        return $this->create($input);
    }

    public function getDepartmentInfo($id = null)
    {
        $data = [];
        try
        {
            $department = $this->findOrFail($id);
            $data       = $department->toArray();
        }
        catch(ModelNotFoundException $e)
        {
            return $data;
        }

        return $data;
    }

    public function updateDepartment($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try
        {
            $department = $this->findOrFail($id);
            $department->update($input);
            $status     = $department->id;
        } catch(ModelNotFoundException $e) {
            return $status;
        }
    }

    public function deleteDepartment($id = null)
    {
        $status = 0;
        try
        {
            $department = $this->findOrFail($id);
            $department->delete();
            $status     = 1;
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
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        
        return $query->paginate($limit);
    }
}
