<?php

namespace Minuz\Api\Controllers;

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

        $acc = new Account($session->email, $session->nickname);
        $emails = $acc->viewAllMails();
        
        $response::Response(200, 'None', 'Ok', ['Data' => $emails]);
    }
    
    
    
    public function send(Requester $request, Responser $response)
    {
        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }
        
        $data = $request::body();
        $data = Validator::HydrateNulls($data, '');
        $acc = new Account($session->email, $session->nickname);
        
        $acc->sendMail($data['reciever'], $data['text'], $data['date']);

        $response::Response(201, 'None', 'Email sent sucessfully');
        return;
    }

}