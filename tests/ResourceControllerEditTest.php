<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;
use MattDaneshvar\ResourceController\Tests\Utilities\TaskWithCustomRouteKeyName;

class ResourceControllerEditTest extends BaseCase
{
    /** @test */
    public function it_returns_the_edit_view()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->edit($task->id)->render();

        $this->assertStringContainsString("edit $task->name", $response);
    }

    /** @test */
    public function it_returns_the_edit_view_with_custom_route_key_names()
    {
        $task = TaskWithCustomRouteKeyName::create(['name' => 'Do groceries!', 'slug' => 'do-groceries']);

        $controller = new class extends ResourceController {
            protected $resource = TaskWithCustomRouteKeyName::class;

            protected $resourceName = 'task';

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->edit($task->slug)->render();

        $this->assertStringContainsString("edit {$task->name}", $response);
    }
}
