<?php

namespace Minuz\Api\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Minuz\Api\Http\{Requester, Responser};
use Minuz\Api\JWK\JWK;
use Minuz\Api\Tools\Validator;

use Minuz\Api\Repository\Safe\Safe;
use Minuz\Api\Model\Account\Account;

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

        $payload = [
            'email' => $acc->email(),
            'nickname' => $acc->nickName
        ];

        $token = $this->saveSessionToken($payload);
        $this->sucessfulLoginProcess($response, $token);
        
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
        
        $payload = [
            'email' => $acc->email(),
            'nickname' => $acc->nickName
        ];

        $token = $this->saveSessionToken($payload);
        $this->sucessfulLoginProcess($response, $token);
        
        return;
    }
    
    
    
    public function logout(Requester $request, Responser $response)
    {
        session_destroy();
        $response::Response(200, 'None', 'logout executed sucessfully');
    }
    
    
    
    private function saveSessionToken(array $payload): string
    {
        $token = JWT::encode($payload, JWK::JWT_KEY, 'HS256');
        $_SESSION[ 'savedSession'] = $token;
        return $token;
    }
    
    
    
    private function sucessfulLoginProcess(Responser $response, string $token): void
    {
        $response::Response(200, message: "You are now loged in", jwt: $token);
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