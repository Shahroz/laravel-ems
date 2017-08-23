<?php

namespace App;

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
    protected $guarded = [];

    public function getAllDepartments()
    {
        return $this->all();
    }

    public function getDepartments($page=5)
    {
        return $this->paginate($page);
    }

    public function addDepartment($input=[])
    {
        if (empty($input)) return 0;

        $department               = new Department;
        $department->name         = $input->name;
        $department->save();

        return $department->id;
    }

    public function getDepartmentInfo($id=0)
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

    public function updateDepartment($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;

        $department           = null;
        try
        {
            $department       = $this->findOrFail($id);
            $department->name = $input->name;

            $department->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $department->id;
    }

    public function deleteDepartment($id=0)
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
            if ($constraint != null) {
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
}
