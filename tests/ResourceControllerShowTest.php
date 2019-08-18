<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;
use MattDaneshvar\ResourceController\Tests\Utilities\TaskWithCustomRouteKeyName;

class ResourceControllerShowTest extends BaseCase
{
    /** @test */
    public function it_returns_the_show_view()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->show($task->id)->render();

        $this->assertStringContainsString("showing {$task->name}", $response);
    }

    /** @test */
    public function it_returns_the_show_view_with_custom_route_key_names()
    {
        $task = TaskWithCustomRouteKeyName::create(['name' => 'Do groceries!', 'slug' => 'do-groceries']);

        $controller = new class extends ResourceController {
            protected $resource = TaskWithCustomRouteKeyName::class;

            protected $resourceName = 'task';

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->show($task->slug)->render();

        $this->assertStringContainsString("showing {$task->name}", $response);
    }
}
