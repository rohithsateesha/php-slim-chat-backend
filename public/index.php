<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

$container = new Container();

// Set up settings
$settings = require __DIR__ . '/../src/settings.php';
$settings($container);

// Set up dependencies
$dependencies = require __DIR__ . '/../src/dependencies.php';
$dependencies($container);

AppFactory::setContainer($container);
$app = AppFactory::create();

// Add body parsing middleware
$app->addBodyParsingMiddleware();

// Register routes
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);

// Run app
$app->run();
