# ResourceController
Resource controller generic implementation for Laravel 5.
## Installation
Require the resource controller package using composer:
```
composer require four13/resource-controller
```
## 
Extend `ResourceController` and implement the `newModel()` and optionally the `rules()` method. 
```php
<?php

use App/Models/Task;
use Four13/ResourceController/ResourceController;

class TasksController extends ResourceController
{
  protected function newModel()
  {
    return new Task();
  }
  
  protected function rules()
  {
    return [
      'name' => 'required|max:200'
    ];
  }
}
```
The `TasksController` in the example above will now have implementation for generic RESTful methods inherited from the `ResourceController` class.  With the current defaults:
* `TasksController@create` will return the `tasks.create` view.
* `TasksController@store` will validate request inputs against `TasksController@rules` and persist a `Task` object to the storage. 
* `TasksController@edit` will retrieve the specified model by ID and return the `tasks.edit` view with `['task' => $task]` parameters.
* etc.

## Notes
This package is still under development and is not recommended for use in production.
