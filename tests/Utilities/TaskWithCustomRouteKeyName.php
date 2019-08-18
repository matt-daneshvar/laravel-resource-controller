<?php

namespace MattDaneshvar\ResourceController\Tests\Utilities;

class TaskWithCustomRouteKeyName extends Task
{
    protected $guarded = [];

    protected $table = 'tasks';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
