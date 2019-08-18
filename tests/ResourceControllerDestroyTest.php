<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;
use MattDaneshvar\ResourceController\Tests\Utilities\TaskWithCustomRouteKeyName;

class ResourceControllerDestroyTest extends BaseCase
{
    /** @test */
    public function it_destroys_the_specified_model()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $controller->destroy($task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_destroys_the_specified_model_with_custom_route_key_names()
    {
        $task = TaskWithCustomRouteKeyName::create(['name' => 'Do groceries!', 'slug' => 'do-groceries']);

        $controller = new class extends ResourceController {
            protected $resource = TaskWithCustomRouteKeyName::class;

            protected $resourceName = 'task';

            protected $viewsPath = 'tests::tasks';
        };

        $controller->destroy($task->slug);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
