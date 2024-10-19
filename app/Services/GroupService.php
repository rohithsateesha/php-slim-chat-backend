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

    public function createGroup($data)
    {
        return $this->groupRepository->create($data);
    }

    public function joinGroup($groupId, $userId)
    {
        $this->groupRepository->addUserToGroup($groupId, $userId);
    }

    public function getGroupMessages($groupId)
    {
        return $this->groupRepository->getGroupMessages($groupId);
    }
}
