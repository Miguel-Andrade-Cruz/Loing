<?php

namespace Minuz\Loing\Model\Account\Email;

use Minuz\Loing\DataBase\Library\MailServer;
use Minuz\Loing\Model\Account\Email\Mail;


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
        $this->update();
    }



    public function __tostring()
    {
        return $this->emailAdress;
    }



    public function sendMail(string $reciever, string $text): void
    {
        $today = new \DateTime('now');
        $mail = new Mail($this->emailAdress, $reciever, $text, $today->format('Y-m-d'));
        
        $this->stock->send($mail);
    }



    public function update()
    {
        $this->mailBox = $this->stock->mailBox($this->emailAdress);
    }



    public function viewAllMails(): string
    {
        $this->update();
        $mails = '';
        
        while ( ! $this->mailBox->isEmpty() ) {
            $mails . $this->mailBox->pop();
        }
        $mails . PHP_EOL . 'Caixa de entrada vazia';
        
        return $mails;
    }
    
    
    
    public function viewLastMail(): string
    {
        $this->update();

        if ( $this->mailBox->isEmpty() ) {
            return "Caixa de entrada vazia";
        }
        return $this->mailBox->pop();
    }
}