<?php

namespace App\Services;
use App\Repositories\ConferenceRepository;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;

class ConferenceService
{
    protected $conferenceRepository;
    protected $userRepository;
    protected $eventRepository;

    public function __construct(ConferenceRepository $conferenceRepository, UserRepository $userRepository, EventRepository $eventRepository)
    {
        $this->conferenceRepository = $conferenceRepository;
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents($type = 'system')
    {
        return $this->conferenceRepository->getByType($type);
    }

    public function getAllEventsPaginate($type = 'system', $count = 5)
    {
        $user = $this->userRepository->getAuthUser();
        return $this->eventRepository->getByTypeUserPaginate($type, $user->id, $count);
    }

}
