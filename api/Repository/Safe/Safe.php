<?php

namespace Minuz\Api\Repository\Safe;

use Minuz\Api\Config\Connection\ConnectionCreator;

class Safe
{
    protected static \PDO $pdo;

    private const LOGIN_QUERY = 
    "
    SELECT nickname, email FROM loingdb.accounts acc
    WHERE acc.email = ':email'
    AND acc.password = ':password';
    "
    ;


    private const SIGN_UP_CHECK =
    "
    SELECT COUNT(*) FROM loingdb.accounts acc
    WHERE acc.email = :email; 
    "
    ;


    private const SIGN_UP_QUERY = 
    "
    INSERT INTO loingdb.accounts (nickname, email, password)
    VALUES (:nickname, :email, :password);
    "
    ;


    public function __construct()
    {
        self::$pdo = ConnectionCreator::connect();
    }



    public function Login(string $email, string $password): array|false
    {
        $filled_query = self::queryFiller(
            self::LOGIN_QUERY,
            [':email', ':password'],
            [$email, $password]
        );

        $accountData = self::$pdo->query($filled_query)->fetch(\PDO::FETCH_ASSOC);
        if ( ! $accountData ) {
            return false;
        }
        
        return $accountData;
    }



    public function SignUp(string $nickName, string $email, string $password): bool
    {
        $checking = self::$pdo->prepare(self::SIGN_UP_CHECK)->execute([':email' => $email]);
        if ( $checking == 1) {
            return false;
        }

        self::$pdo->prepare(self::SIGN_UP_QUERY)
            ->execute([
                ':nickname' => $nickName,
                ':email' => $email,
                ':password' => $password
            ]);
        
        return true;
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