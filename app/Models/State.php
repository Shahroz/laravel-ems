<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state';

    protected $fillable = [
        'name', 'country_id'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    public function getAllStates()
    {
        return $this->all();
    }

    public function getStates($page = 5)
    {
        DB::table('state')
            ->leftJoin('country', 'state.country_id', '=', 'country.id')
            ->select('state.id', 'state.name', 'country.name as country_name', 'country.id as country_id')
            ->paginate($page);
    }

    public function getStateInfo($id = null)
    {
        $data = [];
        try
        {
            $state = $this->findOrFail($id);
            $data  = $state->toArray();
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    public function getStateList($page = 5)
    {
        return $this->paginate($page);
    }

    public function addState($input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        $this->create($input);
    }

    public function updateState($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try
        {
            $state = $this->findOrFail($id);
            $state->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    public function deleteState($id = null)
    {
        $status = 0;
        try
        {
            $state = $this->findOrFail($id);
            $state->delete();
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

        return $query->paginate($limit);
    }
}
