<?php

namespace Minuz\Api\Repository\Library;

use Minuz\Api\Config\Connection\ConnectionCreator;
use Minuz\Api\Model\Account\Email\Mail;

class MailServer
{
    private \PDO $pdo; 


    public function __construct()
    {
        $this->pdo = ConnectionCreator::connect();
    }

}