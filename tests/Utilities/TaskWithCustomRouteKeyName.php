<?php

namespace MattDaneshvar\ResourceController\Tests\Utilities;

use Illuminate\Database\Eloquent\Model;

class TaskWithCustomRouteKeyName extends Task
{
    protected $guarded = [];

    protected $table = 'tasks';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
