<?php

use Slim\App;
use App\Controllers\UserController;
use App\Controllers\GroupController;
use App\Controllers\MessageController;

return function(App $app) {

    // User routes
    $app->post('/users', [UserController::class, 'create']);
    $app->get('/users/{id}', [UserController::class, 'get']);

    // Group routes
    $app->post('/groups', [GroupController::class, 'create']);
    $app->post('/groups/{groupId}/join', [GroupController::class, 'join']);
    $app->get('/groups/{groupId}/messages', [MessageController::class, 'list']);

    // Message routes
    $app->post('/groups/{groupId}/messages', [MessageController::class, 'create']);
    $app->get('/', function ($request, $response, $args) {
        $response->getBody()->write('Chat API is running.');
        return $response;
    });

};
