<?php

namespace App;

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

    public function getStates($page=5)
    {
        DB::table('state')
            ->leftJoin('country', 'state.country_id', '=', 'country.id')
            ->select('state.id', 'state.name', 'country.name as country_name', 'country.id as country_id')
            ->paginate($page);
    }

    public function getStateInfo($id=0)
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

    public function getStateList($page=5)
    {
        return $this->paginate($page);
    }

    public function addState($input=[])
    {
        if (empty($input)) return 0;

        $state               = new State;
        $state->name         = $input->name;
        $state->country_id   = $input->country_id;
        $state->save();

        return $state->id;
    }

    public function updateState($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;
        $state = null;

        try
        {
            $state               = $this->findOrFail($id);
            $state->name         = $input->name;
            $state->country_id   = $input->country_id;

            $state->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $state->id;
    }

    public function deleteState($id=0)
    {
        if (empty($id)) return 0;
        $this->where('id', $id)
            ->delete();
        return 1;
    }

    public function getSearchingQuery($constraints=[], $limit=5) {
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
        return $query->paginate($limit);
    }
}
