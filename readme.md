# REST Controller for Laravel 5.x
General implementation for Laravel 5.x resource controllers.

By assuming a few conventions this package takes care of the repetitive implementation of 
the CRUD (create, read, update, and delete) operations on a base controller which you can 
fully customize and extend to your liking. 

## Installation
Require the package using composer:
```
composer require matt-daneshvar/rest
```
## Usage
Include the `Rest` trait in your controller, and specify a `$resource`. Optionally define a `$rules` 
property to enforce validation before `store` and `update` operations.

```php
<?php

use App\Task;
use MattDaneshvar\Rest\Rest;

class TasksController
{
  use Rest;

  protected $resource = Task::class;

  protected $rules = ['name' => 'required|max:200'];
}
```
The `TasksController` in the example above will now have general implementation for all RESTful verbs. 
That includes:
* A `create` method that returns the `tasks.create` view.
* A `show` method that returns the `tasks.show` view injected with the relevant `Task` model.
* A `create` method that returns the `tasks.create` view.
* A `store` method that validates* the request against `$rules`, persists a `Task` object,
 and redirects user back to the url corresponding to the `TasksController@index` action. 
* An `edit` method that returns the `tasks.edit` view injected with the relevant `Task` model.
* An `update` method that validates* the request against `$rules`, updates the relevant `Task` object,
 and redirects user back to the url corresponding to the `TasksController@index` action. 
* A `destory` method that deletes the relevant `Task` object, and redirects user back to the url corresponding to the `TasksController@index` action. 

*should the validation fail, user is redirected `back()` with all inputs and errors flashed to the session.

## Routing
This package is designed to match Laravel's resource controllers. 
Creating a route rule for this controller is simple:
```php
Route::resource('tasks', 'TasksController');
``` 

### Limiting the exposed CRUD operations
While the `Rest` trait automatically adds all CRUD operations to your controller, you may wish 
to limit the available operations available for your specific resource. You could achieve that
by limiting the routes you expose in your application:
```php
Route::resource('tasks', 'TasksController', ['only' => ['index', 'show']]);
``` 

## Validation
Most real-world applications would validate `store` and `update` requests before 
persisting anything to the database. 

Specifying a `$rules` property on your controller, informs the `Rest` trait to validate user's 
request against those rules in both `store` and `update` operations.

```php
class TasksController
{
  use Rest;

  protected $resource = Task::class;

  protected $rules = ['name' => 'required|max:200'];
}
```

If you wish to use different rules for `store` and `update` operations, you may specify them separately:

```php
class TasksController
{
  use Rest;

  protected $resource = Task::class;

  protected $storeRules = ['name' => 'required|max:200'];
  
  protected $updateRules = ['name' => 'required|max:200'];
}
```

## Pagination
In most situations, your application's `index` would use pagination instead of dumping your models into 
the view all at once. The `Rest` trait assumes `20` items per page. To change this number define the 
`$perPage` attribute, or set it to `null` to disable pagination altogether.
```php
class TasksController
{
  use Rest;

  protected $resource = Task::class;

  protected $perPage = 10;
}
```

## Other configurations
While assuming a set of default conventions with sensible defaults to minimize code repetition
in most cases, this package is also packed with a bunch of configuration options to allow you 
customize your `Rest` as and when needed.

```php
class TasksController
{
  use Rest;

  protected $resource = Task::class;

  protected $rules = ['name' => 'required|max:200'];

  protected $storeRules = ['name' => 'required|max:200'];
  
  protected $updateRules = ['name' => 'required|max:200'];
  
  protected $attributes = ['name'];
  
  protected $storeAttributes = ['name'];
  
  protected $updateAttributes = ['name'];
  
  protected $viewsDirectory = 'tasks';
  
  protected $views = [
    'create' => 'tasks.new'
  ];
}
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.