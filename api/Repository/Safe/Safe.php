<?php

namespace Minuz\Api\Repository\Safe;

use Minuz\Api\Config\Connection\ConnectionCreator;
use Minuz\Api\Config\PDOQueries\PDOQueries;
use Minuz\Api\Model\Account\Account;

class Safe
{
    protected static \PDO $pdo;


    public function __construct()
    {
        self::$pdo = ConnectionCreator::connect();
    }



    public function Login(string $email, string $password): Account|false
    {
        $filledQuery = self::queryFiller(
            PDOQueries::LOGIN_QUERY,
            [':email', ':password'],
            [$email, $password]
        );

        $accData = self::$pdo->query($filledQuery)->fetch(\PDO::FETCH_ASSOC);
        if ( ! $accData ) {
            return false;
        }
        
        return new Account($accData['email'], $accData['nickname']);
    }



    public function SignUp(string $nickName, string $email, string $password): Account|false
    {
        $filledQuery = self::queryFiller(PDOQueries::SIGN_UP_CHECK_QUERY, [':email'], [$email]);
        $checking = self::$pdo->query($filledQuery)->fetch(\PDO::FETCH_ASSOC);
        $checking = $checking['checking'];

        if ( $checking == 1 ) {
            return false;
        }

        self::$pdo->prepare(PDOQueries::SIGN_UP_QUERY)
            ->execute([
                ':nickname' => $nickName,
                ':email' => $email,
                ':password' => $password
            ]);
        
        return $this->Login($email, $password);
    }



    private static function queryFiller(string $query, array $filler, array $filling): string
    {
        $filled_query = str_replace(
            $filler,
            $filling,
            $query
        );

        return $filled_query;
    }
}