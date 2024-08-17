<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\{Requester, Responser};

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
        $data = Validator::HydrateNulls($data, '');
        
        
        if ( ! filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {
            $this->wrongEmailFormatProcess($response);
            return;
        }
        
        $acc = self::$safe->Login($data['email'], $data['password']);
        if ( ! $acc ) {
            $this->wrongLoginProcess($response);
            return;
        }
        
        $this->saveSession($data['email'], $acc->nickName);
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
        }
        
        $this->saveSession($data['email'], $acc->nickName);
        $this->sucessfulLoginProcess($response, $acc);

        return;
    }



    public function logout(Requester $request, Responser $response)
    {
        session_destroy();
        
        $responseData = [
            'Status Message' => 'Ok',
            'Warning' => 'None'
        ];
        
        $response::Response($responseData, 200);
    }



    private function saveSession(string $email, string $nickName): void
    {
        $_SESSION['nickname'] = $nickName;
        $_SESSION['email'] = $email;

        return;
    }
    
    
    
    private function sucessfulLoginProcess(Responser $response, Account $acc): void
    {
        $responseData = [
            'Status Message' => 'Ok',
            'Warning' => 'None',
            'Data' => [
                'nickname' => $acc->nickName,
                'email' => $acc->email()
            ]
        ];
        
        $response::Response($responseData, 200);
        return;
    }



    private function wrongLoginProcess(Responser $response): void
    {
        $responseData = [
            'Status Message' => 'Error',
            'Warning' => 'Incorect Email or password.'
        ];
        
        $response::Response($responseData, 400);
        return;
    }



    private function wrongEmailFormatProcess(Responser $response): void
    {
        $responseData = [
            'Status Message' => 'Error',
            'Warning' => 'Incorrect email format, please insert a valid email.'
        ];

        $response::Response($responseData, 401);

        return;
    }



    private function accountAlreadyExistsProcess(Responser $response): void
    {
        $responseData = [
            'Status message' => 'Issue',
            'Warning' => 'Account already exists with this email'
        ];
        
        $response::Response($responseData, 409);
        return;

    }
}