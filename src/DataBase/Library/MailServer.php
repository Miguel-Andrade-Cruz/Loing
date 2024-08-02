<?php

namespace Minuz\Loing\DataBase\Library;

use Minuz\Loing\Config\Connection\ConnectionCreator;
use Minuz\Loing\Model\Account\Email\Mail;

class MailServer
{
    private \PDO $pdo; 


    public function __construct()
    {
        $this->pdo = ConnectionCreator::connect();
    }



    public function mailBox(string $emailAdress): \Ds\Stack
    {
        $query = MailServerQueries::mailbox($emailAdress);

        $mailBoxtInfo = $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);

        $mailBox = new \Ds\Stack();

        foreach ($mailBoxtInfo as $mailInfo) {
            $mail = new Mail($mailInfo['emailSender'], $mailInfo['emailReciever'], $mailInfo['text'], $mailInfo['date']);
            $mailBox->push($mail);
        }

        return $mailBox;
    }



    public function send(Mail $mail)
    {
        $query = MailServerQueries::send($mail->reciever, $mail->sender, $mail->text, $mail->date->format('Y-m-d'));

        $this->pdo->exec($query);
    }



}