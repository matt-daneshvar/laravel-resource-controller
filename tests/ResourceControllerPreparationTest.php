<?php

namespace MattDaneshvar\ResourceController\Tests;

use MattDaneshvar\ResourceController\ResourceController;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class ResourceControllerPreparationTest extends BaseCase
{
    /** @test */
    public function it_assumes_resource_name_based_on_the_specified_model_class()
    {
        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            public function getResourceName()
            {
                return $this->resourceName;
            }
        };

        $this->assertEquals('task', $controller->getResourceName());
    }

    /** @test */
    public function it_assumes_views_path_based_on_the_specified_model_class()
    {
        $controller = new class extends ResourceController {
            protected $resource = Task::class;

            public function getViewsPath()
            {
                return $this->viewsPath;
            }
        };

        $this->assertEquals('tasks', $controller->getViewsPath());
    }
}
