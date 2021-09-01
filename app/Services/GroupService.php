<?php

namespace App\Services;
use App\Repositories\GroupRepository;

class GroupService
{
    protected $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function getGroupsName()
    {
        return $this->groupRepository->getGroupsWithRelations();
    }

}
