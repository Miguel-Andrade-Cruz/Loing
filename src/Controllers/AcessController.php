<?php

namespace Minuz\Api\Controllers;

use Firebase\JWT\JWT;
use Minuz\Api\Http\{Requester, Responser};
use Minuz\Api\JWK\JWK;
use Minuz\Api\Model\Account\Account;
use Minuz\Api\Repository\Safe\Safe;

session_start();

class AcessController
{
    private static Safe $safe;
    public function __construct() { self::$safe = new Safe(); }

    public function login(Requester $request, Responser $response): void
    {
        $data = $request::auth();
        
        if ( ! filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {
            $this->wrongEmailFormatProcess($response);
            return;
        }
        
        $acc = self::$safe->Login($data['email'], $data['password']);
        if ( ! $acc ) {
            $this->wrongLoginProcess($response);
            return;
        }
        
        $this->sucessfulLoginProcess($response, $acc);        
        return;
    }
    
    
    
    public function signup(Requester $request, Responser $response)
    {
        $data = $request::body();
        
        if ( ! filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {
            $this->wrongEmailFormatProcess($response);
            return;
        }
        
        $acc = self::$safe->Signup($data['nickname'], $data['email'], $data['password']);
        if ( ! $acc ) {
            $this->accountAlreadyExistsProcess($response);
            return;
        }

        $this->sucessfulLoginProcess($response, $acc);
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
        
        $token = JWT::encode($responseData, JWK::JWT_KEY, 'HS256');
        
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
}