<?php

require_once '../../../vendor/autoload.php';

use Minuz\Api\core\message\Request;
use Minuz\Api\core\message\Response;
use Minuz\Loing\DataBase\Safe\Safe;
use Minuz\Loing\Model\Account\Account;

if ( Request::method() != 'POST' ) {
    echo Response::unsafe_operation_response();
    return;
}

$safe = new Safe();
$request = Request::request();

$acc = new Account();

$accData = $acc->SignUp($request['nickname'], $request['email'], $request['password']);

if ( $accData == false ) {
    echo Response::json(['message' => 'Warning: Error on creating account.']);
    return;
}

echo Response::json([
    'message' => 'OK',
    'nickname' => $accData['nickname'],
    'email' => $accData['email']
]);
