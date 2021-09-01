<?php

namespace App\Services;
use App\Repositories\CityRepository;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getCitiesName()
    {
        return $this->cityRepository->getCitiesWithRelations();
    }

    public function getCityById(int $id)
    {
        return $this->cityRepository->getCityById($id);
    }

}
