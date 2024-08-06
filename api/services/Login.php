<?php

namespace Minuz\Api\core\resources;

use Minuz\Api\Model\Account\Account;

class Login
{


    public function Login(string $email, string $password): array
    {
        $acc = new Account();
        $accData = $acc->Login($email, $password);

        return $accData;
    }
}
