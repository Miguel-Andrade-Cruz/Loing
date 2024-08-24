<?php

namespace Minuz\Api\Services;

use Minuz\Api\Model\Account\Account;

class Acess
{


    public function Login(string $email, string $password): array
    {
        $acc = new Account();
        $accData = $acc->Login($email, $password);

        return $accData;
    }
}
