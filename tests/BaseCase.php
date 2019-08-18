<?php

namespace MattDaneshvar\ResourceController\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Database\Eloquent\Collection;
use MattDaneshvar\ResourceController\Tests\Utilities\Task;

class BaseCase extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'tests');
    }

    /**
     * Load views from the given path.
     *
     * @param $path
     * @param $namespace
     */
    protected function loadViewsFrom($path, $namespace)
    {
        $this->app['view']->addNamespace($namespace, $path);
    }

    /**
     * Create n dummy tasks.
     *
     * @param int $n
     * @return \Illuminate\Support\Collection $tasks
     */
    protected function createTasks($n = 1)
    {
        $tasks = new Collection();
        for ($i = 1; $i <= $n; $i++) {
            $tasks->add(Task::create(['name' => "Task $i"]));
        }

        return $tasks;
    }
}
