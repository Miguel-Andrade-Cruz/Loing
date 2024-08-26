<?php

require_once '../vendor/autoload.php';
require_once '../src/Routes/Routes.php';

use Minuz\Api\Core\Core;
use Minuz\Api\Http\Router;

Core::dispatch(Router::$routes);