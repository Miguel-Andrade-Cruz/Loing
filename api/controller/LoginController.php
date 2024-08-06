<?php

namespace Minuz\Api\controller;
use Minuz\Api\Model\Account\Account;

class LoginController extends Controller
{
    private string $email;
    private string $password;


    public function Processor(): array
    {
        $acc = new Account();
        $accData = $acc->Login($this->email, $this->password);
        
        return $accData;
    }



    protected function Hydrate($requestInfo)
    {
        $data = $requestInfo['data'];

        $this->email = $data['email'];
        $this->password = $data['password'];
    }
}