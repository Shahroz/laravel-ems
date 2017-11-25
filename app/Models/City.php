<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    protected $guarded = [
        'id'
    ];

    /**
     * Get state of city
    */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
     * Get all cities by specific state
     * @param null $stateId
     * @return array
     */
    public function getCitiesByState($stateId = null)
    {
        $data = [];
        if (empty($stateId)) {
            return $data;
        }

        $data = $this->where('state_id', $stateId)
            ->get()
            ->toArray();
        return $data;
    }

    /**
     * Get paginated cities
     * @param int $page
     * @return mixed
     */
    public function getCities($page = 5)
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
     * Get city info
     * @param null $id
     * @return array
     */
    public function getCityInfo($id = null)
    {
        $data = [];
        try
        {
            $city = $this->findOrFail($id);
            $data = $city->toArray();
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    /**
     * Add new city
     * @param array $input
     * @return int
     */
    public function addCity($input = [])
    {
        if (empty($input)) {
            return 0;
        }

        return $this->create($input);
    }

    /**
     * Update city by id
     * @param null $id
     * @param array $input
     * @return int
     */
    public function updateCity($id = null, $input = [])
    {
        $status = 0;
        try
        {
            $city = $this->findOrFail($id);
            $city->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    /**
     * Delete city by id
     * @param null $id
     * @return int
     */
    public function deleteCity($id = null)
    {
        $status = 0;
        try
        {
            $city = $this->findOrFail($id);
            $city->delete();
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    /**
     * Get filtered cities list
     * @param array $constraints
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null
     */
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
