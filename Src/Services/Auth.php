<?php
namespace Minuz\Api\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;

use Minuz\Api\Model\Account\Account;
use Minuz\Api\Repository\Safe\Safe;
use Minuz\Api\Statements\Statements;

class Auth
{
    public static function Login(array|bool $auth): Account|string
    {
        $safe = new Safe();
        
        if ( ! $auth ) {
            return Statements::$LOGIN_EMPTY;
        }
        if ( ! filter_var($auth['email'], FILTER_VALIDATE_EMAIL) ) {
            return Statements::$INVALID_EMAIL_FORMAT;
        }

        $acc = $safe->Login($auth['email'], $auth['password']);
        return $acc;
    }



    public static function Signup(array|bool $auth): Account|string
    {
        $safe = new Safe();
        
        if ( ! isset($auth['nickname'], $auth['email'], $auth['password'])) {
            return Statements::$LOGIN_EMPTY;
        }
        if ( ! filter_var($auth['email'], FILTER_VALIDATE_EMAIL) ) {
            return Statements::$INVALID_EMAIL_FORMAT;
        }

        $acc = $safe->SignUp($auth['nickname'], $auth['email'], $auth['password']);
        return $acc;
    }



    public static function SessionLogin(): \stdClass|string
    {
        if ( ! isset($_SESSION['session']) ) {
            self::loginFailedProcess();
            return Statements::$LOGIN_EXPIRED;
        }
        
        $requestSession =  Requester::session();
        if ( ! $requestSession == $_SESSION['session'] ) {
            self::loginFailedProcess();
            return Statements::$OTHER_LOGIN_TOKEN;
        }
        
        try {
            $session = JWT::decode($requestSession, new Key($_ENV['JWT_KEY'], 'HS256'));
        } catch (\UnexpectedValueException $e) {
            self::loginFailedProcess();
            return Statements::$INVALID_LOGIN_TOKEN;
        }

        return $session;
    }


    
    private static function loginFailedProcess(): void
    {
        Responser::Response(400, 'Error', "Your session login falied, please make a new login");
        return;
    }
}
