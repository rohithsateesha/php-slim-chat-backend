<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use DI\Container;

return function(Container $container) {

    // Get settings from the container
    $settings = $container->get('settings');

    // Database
    $capsule = new Capsule;

    $capsule->addConnection($settings['db']);

    // Set the event dispatcher used by Eloquent models... (optional)
    // use Illuminate\Events\Dispatcher;
    // use Illuminate\Container\Container as IlluminateContainer;
    // $capsule->setEventDispatcher(new Dispatcher(new IlluminateContainer));

    // Make this Capsule instance available globally via static methods
    $capsule->setAsGlobal();

    // Setup the Eloquent ORM
    $capsule->bootEloquent();

    // Add to container
    $container->set('db', function() use ($capsule) {
        return $capsule;
    });

    // Controllers
    // ... (rest of your dependency definitions)
};
