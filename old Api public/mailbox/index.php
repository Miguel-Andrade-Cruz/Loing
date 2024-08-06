<?php

require_once '../../../vendor/autoload.php';

use Minuz\Api\core\message\{Request, Response};
use Minuz\Loing\Model\Account\Account;


if ( Request::method() != 'POST' ) {
    echo Response::unsafe_operation_response();
    return;
}

$request = Request::request();

$acc = new Account();
$checking = $acc->Login($request['email'], $request['password']);

if ( $checking == false ) {
    return Response::json(['Warning' => 'Incorrect email or password.']);
}

$mailBox = $acc->viewAllMails();

return 