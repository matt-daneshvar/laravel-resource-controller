<?php

namespace MattDaneshvar\ResourceController\Tests;

use Illuminate\Http\Request;
use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class ResourceControllerStoreTest extends BaseCase
{
    /** @test */
    public function it_persists_a_new_model()
    {
        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';
        };

        $controller->store(new Request(['name' => 'Test Task']));

        $this->assertDatabaseHas('tasks', ['name' => 'Test Task']);
    }

    /** @test */
    public function it_validates_store_input()
    {
        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $rules = [
                'name' => 'required',
            ];
        };

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->store(new Request([]));
    }

    /** @test */
    public function it_validates_store_input_using_specific_store_rules()
    {
        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            protected $viewsPath = 'tests::tasks';

            protected $rules = [
                'name' => 'required',
            ];

            protected $storeRules = [
                'name' => 'numeric',
            ];
        };

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $controller->store(new Request(['name' => 'Test Task']));
    }
}
