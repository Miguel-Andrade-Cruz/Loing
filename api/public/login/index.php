<?php

require_once '../../../vendor/autoload.php';

use Minuz\Api\core\message\{Request, Response};
use Minuz\Loing\DataBase\Safe\Safe;
use Minuz\Loing\Model\Account\Account;


if ( Request::method() != 'POST' ) {
    echo Response::unsafe_operation_response();
    return;
}

$safe = new Safe();
$request = Request::request();

$acc = new Account();

$accData = $acc->Login($request['email'], $request['password']);

if ( $accData == false ) {
    echo Response::json(['message' => 'Warning: Incorrect email or password.']);
    return;
}

echo Response::json([
    'message' => 'OK',
    'nickname' => $accData['nickname'],
    'email' => $accData['email']
]);


