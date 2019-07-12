<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

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
}
