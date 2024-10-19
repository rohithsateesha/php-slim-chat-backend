<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository
{
    public function create($data)
    {
        return Group::create($data);
    }

    public function find($id)
    {
        return Group::find($id);
    }

    public function addUserToGroup($groupId, $userId)
    {
        $group = Group::find($groupId);
        $group->users()->attach($userId);
    }

    public function getGroupMessages($groupId)
    {
        $group = Group::find($groupId);
        return $group->messages()->with('user')->get();
    }
}
