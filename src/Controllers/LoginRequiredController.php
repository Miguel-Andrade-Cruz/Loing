<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\JWK\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;

session_start();

abstract class LoginRequiredController
{
    public function loginSession(Requester $request, Responser $response): \stdClass|bool
    {
        if ( ! isset($_SESSION['session']) ) {
            $this->loginFailedProcess($response);
            return false;
        }
        $requestSession =  $request::session();
        
        if ( ! $requestSession == $_SESSION['session'] ) {
            $this->loginFailedProcess($response);
            return false;
        }
        
        try {
            $session = JWT::decode($requestSession, new Key($_ENV['JWT_KEY'], 'HS256'));
        } catch (UnexpectedValueException $e) {
            $this->loginFailedProcess($response);
            return false;
        }

        return $session;
    }



    private function loginFailedProcess(Responser $response): void
    {
        $response::Response(400, 'Error', "Your session login falied, please make a new login");
        return;
    }
}