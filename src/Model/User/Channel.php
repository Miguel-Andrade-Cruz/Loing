<?php

namespace Minuz\Loing\Model\User;
use Minuz\Loing\Model\User\Account\Account;

class Channel extends Account
{
    // protected Email $email;
    // protected string $password;

    public function __construct(string $email, string $password, \SplStack $mailBox)
    {
        parent::__construct($email, $password, $mailBox);
    }
}