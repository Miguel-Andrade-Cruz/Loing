<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\{Requester, Responser};

use Minuz\Api\Model\Account\Account;
use Minuz\Api\Services\Auth;
use Minuz\Api\Statements\Statements;
use Minuz\Api\Tools\Parse;

class MailboxController
{
    public function inbox(Requester $request, Responser $response)
    {
        $session = Auth::SessionLogin();
        
        $isInvalidToken = $session == Statements::$INVALID_LOGIN_TOKEN;
        $isOtherToken = $session == Statements::$OTHER_LOGIN_TOKEN;
        $isLoginExpired = $session == Statements::$LOGIN_EXPIRED;
        
        if ( $isInvalidToken || $isOtherToken || $isLoginExpired ) {
            return;
        }

        $acc = new Account($session->email, $session->nickname);
        $emails = $acc->viewAllMails();
        
        $response::Response(200, 'None', 'Ok', ['Data' => $emails]);
    }
    
    
    
    public function send(Requester $request, Responser $response)
    {
        $session = Auth::SessionLogin();
        
        $isInvalidToken = $session == Statements::$INVALID_LOGIN_TOKEN;
        $isOtherToken = $session == Statements::$OTHER_LOGIN_TOKEN;
        $isLoginExpired = $session == Statements::$LOGIN_EXPIRED;
        
        if ( $isInvalidToken || $isOtherToken || $isLoginExpired ) {
            return;
        }

        
        $data = $request::body();
        Parse::HydrateNulls($data, '');
        $acc = new Account($session->email, $session->nickname);
        
        $acc->sendMail($data['reciever'], $data['text'], $data['date']);

        $response::Response(201, 'None', 'Email sent sucessfully');
        return;
    }

}