<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\UserController;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use App\Models\User;

class UserControllerTest extends TestCase
{
    protected $userController;

    protected function setUp(): void
    {
        // Initialize Eloquent ORM with an in-memory SQLite database
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Create the users table schema
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('token')->unique();
            $table->timestamps();
        });

        // Initialize the UserRepository, UserService, and UserController
        $userRepository = new UserRepository();
        $userService = new UserService($userRepository);
        $this->userController = new UserController($userService);
    }

    public function testCreateUser()
    {
        // Create a mock request with JSON body
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', '/users')
            ->withHeader('Content-Type', 'application/json');
    
        // Manually set the parsed body
        $request = $request->withParsedBody([
            'username' => 'john_doe',
            'token' => 'abc123',
        ]);
    
        // Create a response object
        $response = new Slim\Psr7\Response();
    
        // Invoke the controller's create method
        $response = $this->userController->create($request, $response, []);
    
        // Assert the response status code and content
        $this->assertEquals(201, $response->getStatusCode());
    
        $response->getBody()->rewind();
        $responseData = json_decode($response->getBody()->getContents(), true);
    
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('john_doe', $responseData['username']);
        $this->assertEquals('abc123', $responseData['token']);
    }
    
}
