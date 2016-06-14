# Generic resource controller implementation for Laravel 5
## Installation
Require the resource controller package using composer:
```
composer require four13/resource-controller
```
## Usage
Extend user controller and implement the `newModel()` method. 
```php
<?php

use App/Models/Photo;
use Four13/ResourceController/ResourceController;

class PhotosController extends ResourceController
{
  protected function newModel()
  {
    return new Photo();
  }
}
```

