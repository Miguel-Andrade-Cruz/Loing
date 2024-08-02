<?php

namespace Minuz\Loing\Model\Account;

use Exception;
use Minuz\Loing\DataBase\Safe\Safe;
use Minuz\Loing\Model\Account\Email\Email;

class Account
{
    private Safe $repository;

    protected Email $email;

    public readonly string $nickName;


    public function __construct()
    {
        $this->repository = new Safe();
    }



    public function Login(string $email, string $password): array|bool
    {
        $data = $this->repository->Login($email, $password);
        
        if ( ! $data ) {
            return false;
        }
        $this->nickName = $data['nickname'];
        $this->email = new Email($data['email']);

        return ['nickname' => $this->nickName, 'email' => (string) $this->email];
    }



    public function SignUp(string $nickName, string $email, string $password): array|bool
    {
        $sucess = $this->repository->SignUp($nickName, $email, $password);

        if ( ! $sucess ) {
            return false;
        }

        return $this->Login($email, $password);
    }



    public function viewLastMail(): string
    {
        return $this->email->viewLastMail();
    }



    public function viewAllMails(): string
    {
        return $this->email->viewAllMails();
    }



    public function sendMail(string $reciever, string $text)
    {
        $this->email->sendMail($reciever, $text);
    }
}