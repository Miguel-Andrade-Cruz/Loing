<?php

namespace Minuz\Api\Repository\Library;

use Minuz\Api\Config\Connection\ConnectionCreator;
use Minuz\Api\Config\PDOQueries\PDOQueries;
use Minuz\Api\Model\Account\Email\Mail;

class MailServer
{
    private static \PDO $pdo; 


    public function __construct()
    {
        self::$pdo = ConnectionCreator::connect();
    }



    public function sendMail(Mail $mail): void
    {
        $mailRead = $mail->read();
        
        self::$pdo->prepare(PDOQueries::SEND_MAIL_QUERY)
        ->execute([
            ':recieverMail' => $mailRead['reciever'],
            ':senderMail'   => $mailRead['sender'],
            ':textMail'     => $mailRead['text'],
            ':dateMail'     => $mailRead['date']
        ]);

        return;
    }



    public function pullMails(string $emailAdress): \Ds\Stack
    {
        $filledQuery = self::queryFiller(PDOQueries::INBOX_QUERY, [':email'], [$emailAdress]);
        $mailBox = $this->mailBoxer(self::$pdo->query($filledQuery));

        return $mailBox;
    }
    
    

    private function mailBoxer(\PDOStatement $statement): \Ds\Stack
    {
        $mailbox = new \Ds\Stack();
        
        while ( $dataFetch = $statement->fetch(\PDO::FETCH_ASSOC) ) {
            
            $mail = new Mail(
                $dataFetch['emailSender'],
                $dataFetch['emailReciever'],
                $dataFetch['text'],
                $dataFetch['date']
            );
            $mailbox->push($mail);
        }

        return $mailbox;
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