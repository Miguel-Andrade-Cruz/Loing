<?php

namespace Minuz\Api\Repository\Library;

use Minuz\Api\Config\Connection\ConnectionCreator;
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
        
        self::$pdo->prepare(self::$SEND_MAIL_QUERY)->execute([
            ':recieverMail' => $mailRead['reciever'],
            ':senderMail'   => $mailRead['sender'],
            ':textMail'     => $mailRead['text'],
            ':dateMail'     => $mailRead['date']
        ]);

        return;
    }



    public function pullMails(string $emailAdress): \Ds\Stack
    {
        $stmt = self::$pdo->prepare(self::$INBOX_QUERY);
        $stmt->execute([':email' => $emailAdress]);
        $mailBox = $this->mailBoxer($stmt);

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



    private static string $INBOX_QUERY = 
    "
    SELECT emailReciever, emailSender, text, date
    FROM loingdb.mailbox m
    WHERE m.emailReciever = :email;
    "
    ;


    private static string $SEND_MAIL_QUERY = 
    "
    INSERT INTO loingdb.mailbox (emailReciever, emailSender, text, date)
    VALUES (:recieverMail, :senderMail, :textMail, :dateMail);
    "
    ;
}