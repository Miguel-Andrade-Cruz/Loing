<?php

namespace Minuz\Api\Repository\Safe;

use Minuz\Api\Config\Connection\ConnectionCreator;
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
        $stmt = self::$pdo->prepare(self::$LOGIN_QUERY);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);

        $accData = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ( ! $accData ) {
            return false;
        }
        
        return new Account($accData['email'], $accData['nickname']);
    }



    public function SignUp(string $nickName, string $email, string $password): Account|false
    {
        $stmt = self::$pdo->prepare(self::$SIGN_UP_CHECK_QUERY);
        $stmt->execute([':email' => $email]);
        $checking = $stmt->fetch(\PDO::FETCH_ASSOC);
        $checking = $checking['checking'];

        if ( $checking == 1 ) {
            return false;
        }

        self::$pdo->prepare(self::$SIGN_UP_QUERY)
            ->execute([
                ':nickname' => $nickName,
                ':email' => $email,
                ':password' => $password
            ]);
        
        return $this->Login($email, $password);
    }



    private static string $LOGIN_QUERY = 
    "
    SELECT nickname, email FROM loingdb.accounts acc
    WHERE acc.email = :email
    AND acc.password = :password;
    "
    ;


    private static string $SIGN_UP_CHECK_QUERY =
    "
    SELECT COUNT(*) AS checking
    FROM loingdb.accounts acc
    WHERE acc.email = :email;
    "
    ;


    private static string $SIGN_UP_QUERY = 
    "
    INSERT INTO loingdb.accounts (nickname, email, password)
    VALUES (:nickname, :email, :password);
    "
    ;
}