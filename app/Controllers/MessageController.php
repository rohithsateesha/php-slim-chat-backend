<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\MessageService;

class MessageController
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function create(Request $request, Response $response, $args)
    {
        $groupId = $args['groupId'];
        $data = $request->getParsedBody();
        $data['group_id'] = $groupId;
        $message = $this->messageService->createMessage($data);
        $response->getBody()->write(json_encode($message));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function list(Request $request, Response $response, $args)
    {
        $groupId = $args['groupId'];
        $messages = $this->messageService->getMessagesByGroup($groupId);
        $response->getBody()->write(json_encode($messages));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
