<?php

namespace App;

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
    protected $guarded = [];

    public function getAllDivisions()
    {
        return $this->all();
    }

    public function getDivisions($page=5)
    {
        return $this->paginate($page);
    }

    public function addDivision($input=[])
    {
        if (empty($input)) return 0;

        $division               = new Division;
        $division->name         = $input->name;
        $division->save();

        return $division->id;
    }

    public function getDivisionInfo($id=0)
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

    public function updateDivision($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;

        $division           = null;
        try
        {
            $division       = $this->findOrFail($id);
            $division->name = $input->name;

            $division->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $division->id;
    }

    public function deleteDivision($id=0)
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
