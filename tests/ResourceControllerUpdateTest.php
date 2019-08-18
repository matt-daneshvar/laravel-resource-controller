<?php

namespace MattDaneshvar\ResourceController\Tests;

use Illuminate\Http\Request;
use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;
use MattDaneshvar\ResourceController\Tests\Utilities\TaskWithCustomRouteKeyName;

class ResourceControllerUpdateTest extends BaseCase
{
    /** @test */
    public function it_updates_the_specified_model()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $controller->update($task->id, new Request(['name' => 'Updated Task']));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Updated Task']);
    }

    /** @test */
    public function it_updates_the_specified_model_with_custom_route_key_names()
    {
        $task = TaskWithCustomRouteKeyName::create(['name' => 'Do groceries!', 'slug' => 'do-groceries']);

        $controller = new class extends ResourceController {
            protected $resource = TaskWithCustomRouteKeyName::class;

            protected $resourceName = 'task';

            protected $viewsPath = 'tests::tasks';
        };

        $controller->update($task->slug, new Request(['name' => 'Updated Task']));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'name' => 'Updated Task']);
    }

    /** @test */
    public function it_validates_update_input()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $rules = [
                'name' => 'required',
            ];
        };

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->update($task->id, new Request([]));
    }

    /** @test */
    public function it_validates_update_input_using_specific_update_rules()
    {
        $task = $this->createTasks(1)->first();

        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $rules = [
                'name' => 'required',
            ];

            protected $updateRules = [
                'name' => 'numeric',
            ];
        };

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->update($task->id, new Request(['name' => 'Test Name']));
    }
}
