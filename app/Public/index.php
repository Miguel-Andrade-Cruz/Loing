<?php

require_once '../../vendor/autoload.php';
require_once '../src/Routes/Routes.php';
require_once '../Src/Config/bootstrap.php';

use Minuz\Api\Core\Core;
use Minuz\Api\Http\Router;

Core::dispatch(Router::$routes);