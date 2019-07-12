<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class ResourceControllerEditTest extends BaseCase
{
    /** @test */
    public function it_returns_the_edit_view()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController
        {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->edit($task->id)->render();

        $this->assertStringContainsString("edit $task->name", $response);
    }
}


