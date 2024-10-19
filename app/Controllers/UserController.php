<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\UserService;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function get(Request $request, Response $response, $args)
    {
        $userId = $args['id'];
        $user = $this->userService->getUser($userId);
        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response, $args)
    {
    $data = $request->getParsedBody();

    if ($data === null) {
        $errorInfo = [
            'error' => 'No data received or unable to parse JSON.',
            'parsedBody' => $data,
            'rawBody' => (string)$request->getBody(),
            'contentType' => $request->getHeaderLine('Content-Type')
        ];

        $response->getBody()->write(json_encode($errorInfo));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $user = $this->userService->createUser($data);
    $response->getBody()->write(json_encode($user));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    
}
