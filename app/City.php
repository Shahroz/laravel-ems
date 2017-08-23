<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

    protected $fillable = [
        'name', 'state_id'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo('\App\State');
    }

    /**
     * @param int $stateId
     * @return array
     */
    public function getCitiesByState($stateId=0)
    {
        $data = [];
        if (empty($stateId)) return $data;

        $cities = $this->where('state_id', $stateId)
            ->get()
            ->toArray();

        return $cities;  
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function getCities($page=5)
    {
        return DB::table('city')
            ->leftJoin('state', 'city.state_id', '=', 'state.id')
            ->select('city.id', 'city.name', 'state.name as state_name', 'state.id as state_id')
            ->paginate($page);
    }

    public function getAllCities()
    {
        $cities = $this->all();
        return $cities;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCityInfo($id=0)
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

    /**
     * @param array $input
     * @return int|mixed
     */
    public function addCity($input=[])
    {
        $id = 0;
        if (empty($input)) return $id;

        $city           = new City;
        $city->name     = $input->name;
        $city->state_id = $input->state_id;
        $city->save();

        return $city->id;
    }

    /**
     * @param int $id
     * @param array $input
     * @return int
     */
    public function updateCity($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;
        $city = null;
        try
        {
            $city           = $this->findOrFail($id);
            $city->name     = $input->name;
            $city->state_id = $input->state_id;
            $city->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $city->id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteCity($id=0)
    {
        if (empty($id)) return 0;
        $this->where('id', $id)
            ->delete();
        return 1;
    }

    /**
     * @param array $constraints
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
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
