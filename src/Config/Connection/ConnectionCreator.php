<?php
namespace Minuz\Api\Config\Connection;

require_once __DIR__ . '/DB_Connection.php';

class ConnectionCreator
{
    public static function connect(): \PDO
    {
        return new \PDO('mysql:LoingDB=loingdb;host=127.0.0.1', USER, PASSWORD);
    }
}