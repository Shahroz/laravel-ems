<?php

namespace App;

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
    protected $guarded = [];

    public function cities()
    {
        return $this->hasMany('\App\City');
    }

    public function getAllCountries()
    {
        return $this->all();
    }

    public function getCountries($page=5)
    {
        return $this->paginate($page);
    }

    public function addCountry($input=[])
    {
        if (empty($input)) return 0;

        $country               = new Country;
        $country->name         = $input->name;
        $country->country_code = $input->country_code;
        $country->save();

        return $country->id;
    }

    public function getCountryInfo($id=0)
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

    public function updateCountry($id=0, $input=[])
    {
        if (empty($input) || empty($id)) 0;

        try
        {
            $country               = $this->findOrFail($id);
            $country->name         = $input->name;
            $country->country_code = $input->country_code;

            $country->save();
        }
        catch(ModelNotFoundException $e)
        {
            return 0;
        }

        return $country->id;
    }

    public function deleteCountry($id=0)
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
        return $query->paginate($limit);
    }
}
