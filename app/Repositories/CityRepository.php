<?php
namespace App\Repositories;

use App\Models\City;
use App\Traits\Languages;

class CityRepository
{
    use Languages;

    protected $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function getCityById($id)
    {
        return City::where('id', $id)
            ->first();
    }

    public function getCitiesWithRelations()
    {
        return City::with(['cityStrings' => function ($query) {
            return $query->where('lang_id', $this->getLangId());
        }])->get();
    }
}
