<?php
namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function getByType(string $type)
    {
        return $this->event->where('type', $type)->get();
    }

    public function getByTypePaginate(string $type, $count = 5)
    {
        return $this->event->where('type', $type)->paginate($count);
    }
    public function getByTypeUserPaginate(string $type, $user_id, $count = 5)
    {
        return $this->event->where('type', $type)
            ->where('user_id', $user_id)
            ->paginate($count);
    }

}
