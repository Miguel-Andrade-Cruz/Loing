<?php

namespace Minuz\Loing\User\Email;

class Email
{
    protected string $emailAdress;
    protected string $password;

    protected \SplStack $mailBox;

    public function __construct(string $emailAdress, string $password)
    {
        if ( ! filter_var($emailAdress, FILTER_VALIDATE_EMAIL) ) {
            throw new \DomainException("Formato de email inválido.");
        }

        $this->emailAdress = $emailAdress;
        $this->password = $password;
        $this->mailBox = new \SplStack();
    }



    public function validate(string $emailAdress, string $password): bool
    {
        if ( $emailAdress == $this->emailAdress && $password == $this->password ) {
            return true;
        }
        return false;
    }
}