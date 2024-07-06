<?php

namespace Minuz\Loing\Model\User\Email;

class Email
{
    public readonly string $email;
    protected \SplStack $mailBox;

    public function __construct(string $email, \SplStack $mailBox)
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            throw new \DomainException('Email inválido, tente novamente');
        }

        $this->email = $email;
        $this->mailBox = $mailBox;
    }



    public function mailBox(): \SplStack
    {
        return $this->mailBox;
    }
}