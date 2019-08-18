<?php

namespace MattDaneshvar\ResourceController\Tests\Utilities;

use MattDaneshvar\ResourceController\ResourceController;

class TasksController extends ResourceController
{
    protected $resource = Task::class;

    protected $viewsPath = 'tests::tasks';
}
