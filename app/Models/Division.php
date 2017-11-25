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
    protected $table = 'division';

    protected $fillable = [
        'name'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];

    public function getAllDivisions()
    {
        return $this->all();
    }

    public function getDivisions($page = 5)
    {
        return $this->paginate($page);
    }

    public function addDivision($input = [])
    {
        if (empty($input)) {
            return 0;
        }

        return $this->create($input);
    }

    public function getDivisionInfo($id = null)
    {
        $data = [];
        try
        {
            $division = $this->findOrFail($id);
            $data     = $division->toArray();
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    public function updateDivision($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try
        {
            $division = $this->findOrFail($id);
            $division->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    public function deleteDivision($id = null)
    {
        $status = 0;
        try
        {
            $division = $this->findOrFail($id);
            $division->delete();
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
                $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        
        return $query->paginate(5);
    }
}
