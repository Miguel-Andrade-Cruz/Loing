<?php

namespace Minuz\Loing\DataBase\Library;


class MailServerQueries
{
    private const QUERY_SEND_MAIL =
    "
    INSERT INTO loingdb.mailbox (emailReciever, emailSender, text, date)
    VALUES ('{ reciever }', '{ sender }', '{ text }', '{ date }');
    ";


    private const QUERY_MAILBOX = 
    "
    SELECT emailReciever, emailSender, text, date FROM loingdb.mailbox mbx
    WHERE mbx.emailReciever = '{ emailAdress }';
    ";


    public static function send(string $reciever, string $sender, string $text, string $date)
    {
        $filledQuery = str_replace(
            ['{ reciever }', '{ sender }', '{ text }', '{ date }'],
            [$reciever, $sender, $text, $date],
            self::QUERY_SEND_MAIL
        );

        return $filledQuery;
    }



    public static function mailbox(string $emailAdress): string
    {
        $filledQuery = str_replace('{ emailAdress }', $emailAdress, self::QUERY_MAILBOX);

        return $filledQuery;
    }
}
