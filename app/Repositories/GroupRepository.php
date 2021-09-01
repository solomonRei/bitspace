<?php
namespace App\Repositories;

use App\Models\Group;
use App\Traits\Languages;

class GroupRepository
{
    use Languages;

    protected $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function getGroupById($id)
    {
        return $this->where('id', $id)
            ->first();
    }

    public function getGroupsWithRelations()
    {
        return Group::with(['groupStrings' => function ($query) {
            return $query->where('lang_id', $this->getLangId());
        }])->isShowen()->get();
    }
}
