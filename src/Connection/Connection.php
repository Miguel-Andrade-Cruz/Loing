<?php

namespace Minuz\Loing\Connection;

class Connection
{
    public static function connect(string $dsn): \PDO
    {
        $user = 'root';

        return new \PDO($dsn, $user, PASSWORD);
    }
}