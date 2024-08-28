<?php

namespace Minuz\Api\Controllers;

session_start();

use Minuz\Api\Http\{Requester, Responser};

use Minuz\Api\Model\Account\Account;
use Minuz\Api\Tools\Validator;
use Minuz\Api\Controllers\LoginRequiredController;

class MailboxController extends LoginRequiredController
{
    public function inbox(Requester $request, Responser $response)
    {
        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }

        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);
        
        $emails = $acc->viewAllMails();
        
        $responseData = [
            'Status Message' => 'Ok',
            'Warning' => 'None',
            'Data' => $emails
        ];
        $response::Response(200, 'None', 'Ok', $emails);
    }
    
    
    
    public function send(Requester $request, Responser $response)
    {
        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }
        
        $data = $request::body();
        $data = Validator::HydrateNulls($data, '');
        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);
        
        $acc->sendMail($data['reciever'], $data['text'], $data['date']);

        $responseData = [
            'Status message' => 'Ok',
            'Warning' => 'None',
            'Info' => 'Email sended sucessfully'
        ];
        $response::Response(201, 'None', 'Email sended sucessfully');
        return;
    }

}