<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class ResourceControllerCreateTest extends BaseCase
{
    /** @test */
    public function it_returns_the_create_view()
    {
        $controller = new class extends ResourceController
        {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->create()->render();

        $this->assertStringContainsString('create a task', $response);
    }
}


