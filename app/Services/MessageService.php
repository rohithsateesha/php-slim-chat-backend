<?php

namespace App\Services;

use App\Repositories\MessageRepository;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage($data)
    {
        return $this->messageRepository->create($data);
    }

    public function getMessagesByGroup($groupId)
    {
        return $this->messageRepository->getMessagesByGroup($groupId);
    }
}
