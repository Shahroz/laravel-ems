<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country';

    protected $fillable = [
        'name', 'country_code'
    ];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [
        'id'
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function getAllCountries()
    {
        return $this->all();
    }

    public function getCountries($page = 5)
    {
        return $this->paginate($page);
    }

    public function addCountry($input = [])
    {
        if (empty($input)) {
            return 0;
        }
        
        return $this->create($input);
    }

    public function getCountryInfo($id = null)
    {
        $data = [];
        try
        {
            $data = $this->findOrFail($id);
            return $data->toArray();
        } catch(ModelNotFoundException $e) {
            return $data;
        }

        return $data;
    }

    public function updateCountry($id = null, $input = [])
    {
        $status = 0;
        if (empty($input)) {
            return $status;
        }

        try
        {
            $country = $this->findOrFail($id);
            $country->update($input);
            $status = 1;
        } catch(ModelNotFoundException $e) {
            return $status;
        }

        return $status;
    }

    public function deleteCountry($id = null)
    {
        $status = 0;
        try
        {
            $country = $this->findOrFail($id);
            $country->delete();
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
