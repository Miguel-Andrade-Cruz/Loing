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
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \DomainException('Formato de email inválido');
        }

        $this->emailAdress = $email;
        $this->stock = new MailServer();
    }



    public function __tostring()
    {
        return $this->emailAdress;
    }



    public function sendMail(string $reciever, string $text): void
    {
        $today = new \DateTime('now');
        $mail = new Mail($this->emailAdress, $reciever, $text, $today->format('Y-m-d'));
        
    }






    public function viewAllMails(): string
    {
        $mails = '';
        
        while ( ! $this->mailBox->isEmpty() ) {
            $mails . $this->mailBox->pop();
        }
        $mails . PHP_EOL . 'Caixa de entrada vazia';
        
        return $mails;
    }
    
    
    
    public function viewLastMail(): string
    {
        if ( $this->mailBox->isEmpty() ) {
            return "Caixa de entrada vazia";
        }
        return $this->mailBox->pop();
    }
}