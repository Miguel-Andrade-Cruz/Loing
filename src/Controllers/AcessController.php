<?php

namespace Minuz\Api\Controllers;

use Firebase\JWT\JWT;
use Minuz\Api\Http\{Requester, Responser};
use Minuz\Api\Model\Account\Account;
use Minuz\Api\Repository\Safe\Safe;
use Minuz\Api\Services\Auth;
use Minuz\Api\Statements\Statements;

session_start();

class AcessController
{
    private static Safe $safe;
    public function __construct() { self::$safe = new Safe(); }

    public function login(Requester $request, Responser $response): void
    {
        $login = Auth::Login($request::auth());
        
        if ( $login == Statements::$LOGIN_EMPTY ) {
            $this->emptyLoginProcess($response);
            return;
        }

        if ( $login == Statements::$INVALID_EMAIL_FORMAT ) {
            $this->wrongEmailFormatProcess($response);
            return;
        }
        
        if ( $login == Statements::$INVALID_LOGIN ) {
            $this->wrongLoginProcess($response);
            return;
        }
        
        $this->sucessfulLoginProcess($response, $login);        
        return;
    }
    
    
    
    public function signup(Requester $request, Responser $response)
    {
        $signin = Auth::Signup($request::body());
        if ( $signin == Statements::$LOGIN_EMPTY ) {
            $this->emptyLoginProcess($response);
            return;
        }
        if ( $signin == Statements::$INVALID_EMAIL_FORMAT ) {
            $this->wrongEmailFormatProcess($response);
            return;
        }
        if ( $signin == Statements::$ACCOUNT_ALREADY_EXISTS ) {
            $this->accountAlreadyExistsProcess($response);
            return;
        }

        $this->sucessfulLoginProcess($response, $signin);
        return;
    }



    public function logout(Requester $request, Responser $response)
    {
        session_destroy();
        $response::Response(200, 'None', 'logout executed sucessfully');
    }



    private function sucessfulLoginProcess(Responser $response, Account $acc): void
    {   
        $responseData = [
            'email' => $acc->email(),
            'nickname' => $acc->nickName
        ];
        
        $token = JWT::encode($responseData, $_ENV['JWT_KEY'], 'HS256');
        $_SESSION['session'] = $token;
        $response::Response(200, 'None', "You are now loged in", ['Token' => $token, 'Expire at' => 'Logout']);
        return;
    }



    private function wrongLoginProcess(Responser $response): void
    {
        $response::Response(400, 'Error', 'Incorrect email or password');
        return;
    }



    private function wrongEmailFormatProcess(Responser $response): void
    {
        $response::Response(401, 'Error', 'Incorrect email format, please insert a valid email.');
        return;
    }



    private function accountAlreadyExistsProcess(Responser $response): void
    {
        $response::Response(409, 'Issue', 'Account already exists with this email');
        return;
    }



    private function emptyLoginProcess(Responser $response)
    {
        $response::Response(401, 'Empty fields', 'Empty email or password fields');
    }
}