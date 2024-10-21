<?php

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use App\Models\User;

class UserServiceTest extends TestCase
{
    protected $userService;

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

        // Initialize the UserRepository and UserService
        $userRepository = new UserRepository();
        $this->userService = new UserService($userRepository);
    }

    public function testCreateUser()
    {
        $data = [
            'username' => 'john_doe',
            'token' => 'abc123',
        ];

        $user = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('john_doe', $user->username);
        $this->assertEquals('abc123', $user->token);
    }

    public function testGetUser()
    {
        // First, create a user directly in the database
        $user = User::create([
            'username' => 'jane_doe',
            'token' => 'def456',
        ]);

        // Retrieve the user using the service
        $retrievedUser = $this->userService->getUser($user->id);

        $this->assertInstanceOf(User::class, $retrievedUser);
        $this->assertEquals('jane_doe', $retrievedUser->username);
        $this->assertEquals('def456', $retrievedUser->token);
    }
}
