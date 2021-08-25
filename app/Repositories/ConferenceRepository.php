<?php
namespace App\Repositories;

use App\Models\Conference;

class ConferenceRepository
{
    protected $conference;

    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
    }

    public function getByType(string $type)
    {
        return $this->conference->where('type', $type)->get();
    }

    public function getByTypePaginate(string $type, $count = 5)
    {
        return $this->conference->where('type', $type)->paginate($count);
    }
    public function getByTypeUserPaginate(string $type, $user_id, $count = 5)
    {
        return $this->conference->where('type', $type)
            ->where('user_id', $user_id)
            ->paginate($count);
    }

}
