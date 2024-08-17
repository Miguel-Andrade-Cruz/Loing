<?php

namespace Minuz\Api\Model\Account;

use Minuz\Api\Config\Statements\StatementConfig;
use Minuz\Api\Repository\DataCenter\DataCenter;
use Minuz\Api\Repository\Safe\Safe;
use Minuz\Api\Model\Account\Email\Email;

class Account
{
    private DataCenter $cloud;

    protected Email $email;

    public readonly string $nickName;


    public function __construct(string $email, string $nickName)
    {
        $this->nickName = $nickName;
        $this->email = new Email($email);

        $this->cloud = new DataCenter();
    }


    public function searchVideo(string $search): array
    {
        return $this->cloud->search($search);
    }



    public function email(): string
    {
        return $this->email;
    }



    public function viewAllMails(): array
    {
        return $this->email->viewAllMails();
    }



    public function sendMail(string $reciever, string $text, string $date): void
    {
        $this->email->sendMail($reciever, $text, $date);
    }
}