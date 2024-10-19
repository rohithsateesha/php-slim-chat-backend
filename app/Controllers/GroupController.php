<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\GroupService;

class GroupController
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function create(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $group = $this->groupService->createGroup($data);
        $response->getBody()->write(json_encode($group));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function join(Request $request, Response $response, $args)
    {
        $groupId = $args['groupId'];
        $data = $request->getParsedBody();
        $userId = $data['user_id'];
        $this->groupService->joinGroup($groupId, $userId);
        $response->getBody()->write(json_encode(['message' => 'User joined the group']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
