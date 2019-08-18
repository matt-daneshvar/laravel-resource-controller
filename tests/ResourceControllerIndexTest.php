<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class ResourceControllerIndexTest extends BaseCase
{
    /** @test */
    public function it_returns_the_index_view()
    {
        $tasks = $this->createTasks(3);

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $response = $controller->index()->render();

        foreach ($tasks as $task) {
            $this->assertStringContainsString($task->name, $response);
        }
    }

    /** @test */
    public function it_paginates_the_index_view()
    {
        $tasks = $this->createTasks(5);

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $perPage = 3;
        };

        $response = $controller->index()->render();

        $this->assertStringContainsString($tasks->first()->name, $response);
        $this->assertStringNotContainsString($tasks->last()->name, $response);
    }

    /** @test */
    public function it_skips_pagination_when_perpage_value_is_null()
    {
        $tasks = $this->createTasks(5);

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $perPage = null;
        };

        $response = $controller->index()->render();

        $this->assertStringContainsString($tasks->first()->name, $response);
        $this->assertStringContainsString($tasks->last()->name, $response);
    }
}
