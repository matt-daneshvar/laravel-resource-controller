<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

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
}
