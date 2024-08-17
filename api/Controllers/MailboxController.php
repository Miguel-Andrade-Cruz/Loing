<?php

namespace Minuz\Api\Controllers;

session_start();

use Minuz\Api\Http\{Requester, Responser};

use Minuz\Api\Model\Account\Account;
use Minuz\Api\Tools\Validator;

class MailboxController
{
    public function inbox(Requester $request, Responser $response)
    {
        if ( ! isset($_SESSION['email']) ) {
            $this->loginRequiredProcess($response);
            return;
        }
        
        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);
        
        $emails = $acc->viewAllMails();
        
        $responseData = [
            'Status Message' => 'Ok',
            'Warning' => 'None',
            'Data' => $emails
        ];
        $response::Response($responseData, 200);
    }
    
    
    
    public function send(Requester $request, Responser $response)
    {
        if ( ! isset($_SESSION['email']) ) {
            $this->loginRequiredProcess($response);
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
        $response::Response($responseData, 201);
        return;
    }



    private function loginRequiredProcess(Responser $response): void
    {
        $responseData = [
            'Status Message' => 'Error',
            'Warning' => 'You need to login before use your email.'
        ];
        $response::Response($responseData, 401);
        return;
    }
}