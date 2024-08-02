<?php

require_once '../../../vendor/autoload.php';

use Minuz\Api\core\message\{Request, Response};
use Minuz\Loing\Model\Account\Account;


if ( Request::method() != 'POST' ) {
    echo Response::unsafe_operation_response();
    return;
}

$request = Request::request();

$account = new Account($request['email'], $request['password']);