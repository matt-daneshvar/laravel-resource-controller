# RESTful Verbs
General implementation for RESTful verbs for Laravel 5.
## Installation
Require the package using composer:
```
composer require four13/resource-controller
```
## 
Use `RestfulVerbs`, implement the `newModel()` and optionally define validation `$rules`. 
```php
<?php

use App/Models/Task;
use Four13/RestfulVerbs/RestfulVerbs;

class TasksController
{
  use RestfulVerbs;

  protected $rules = ['name' => 'required|max:200'];

  protected function newModel()
  {
    return new Task();
  }
}
```
The `TasksController` in the example above will now have implementation for generic RESTful verbs.  With the current defaults:
* `TasksController@create` will return the `tasks.create` view.
* `TasksController@store` will validate request against `$rules` and persist a `Task` object to the storage. 
* `TasksController@edit` will retrieve the specified model by `id` and return the `tasks.edit` view with `['task' => $task]` parameters.
* etc.

## Notes
This package is still under development and is not recommended for use in production.
