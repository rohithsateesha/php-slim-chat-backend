<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    public function create($data)
    {
        return Message::create($data);
    }

    public function getMessagesByGroup($groupId)
    {
        return Message::where('group_id', $groupId)->with('user')->get();
    }
}
