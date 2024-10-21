<?php

use PHPUnit\Framework\TestCase;
use App\Services\GroupService;
use App\Repositories\GroupRepository;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use App\Models\Group;

class GroupServiceTest extends TestCase
{
    protected $groupService;

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

        // Create the groups table schema
        Capsule::schema()->create('groups', function ($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Initialize the GroupRepository and GroupService
        $groupRepository = new GroupRepository();
        $this->groupService = new GroupService($groupRepository);
    }

    public function testCreateGroup()
    {
        $data = [
            'name' => 'General',
        ];

        $group = $this->groupService->createGroup($data);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertEquals('General', $group->name);
    }
}
