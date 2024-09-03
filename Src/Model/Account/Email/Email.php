<?php

namespace Minuz\Api\Model\Account\Email;

use Minuz\Api\Repository\Library\MailServer;
use Minuz\Api\Model\Account\Email\Mail;


class Email
{
    private MailServer $stock;
    protected string $emailAdress;
    protected \Ds\Stack $mailBox;


    public function __construct(string $email)
    {
        $this->emailAdress = filter_var($email, FILTER_VALIDATE_EMAIL);

        $this->stock = new MailServer();
    }



    public function __tostring()
    {
        return $this->emailAdress;
    }



    public function sendMail(string $reciever, string $text, string $date): void
    {
        $mail = new Mail($this->emailAdress, $reciever, $text, $date);
        
        $this->stock->sendMail($mail);
    }



    public function viewAllMails(): array
    {
        $this->update();
        $mails = [];

        if ( $this->mailBox->isEmpty()) {
            return [
                'Your inbox is empty.'
            ];
        }
        
        while ( ! $this->mailBox->isEmpty() ) {
            $mail = $this->mailBox->pop();
            $mails[] = $mail->read();
        }
        
        return $mails;
    }



    private function update()
    {
        $this->mailBox = $this->stock->pullMails($this->emailAdress);
    }
}