<?php

namespace Minuz\Loing\Model\User\Account;

use Minuz\Loing\Model\User\Email\Email;

abstract class Account
{
    protected Email $email;
    protected string $password;


    public function __construct(string $email, string $password, \SplStack $mailBox)
    {
        $this->email = new Email($email, $mailBox);
        $this->password = $password;
    }



    public function mailBox(string $password): \SplStack
    {
        if ( ! $password == $this->password ) {
            throw new \DomainException('Senha incorreta, tente novamente');
        }

        return $this->email->mailBox();
    }
}