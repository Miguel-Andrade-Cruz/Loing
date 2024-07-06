<?php

namespace Minuz\Loing\Model\User\Email;

class Mail
{
    protected string $sender;
    protected string  $reciever;
    protected string $message;
    public readonly string $link;
    protected \DateTimeImmutable $date;


    public function __construct(string $sender, $reciever, string $message, string $link = false, string $date)
    {
        $this->sender = $sender;
        $this->reciever = $reciever;
        $this->message = $message;
        $this->link = $link;
        
        $this->date = new \DateTimeImmutable($date);
    }



    public function __toString()
    {
        $timePassed = $this->date->diff(new \DateTime('now'));
        $timePassed = $timePassed->format('%d days ago');

        return <<<EOL
        Sended $timePassed:
        Dear $this->reciever,
        -------------------------------
        $this->message
        
        [$this->link]


        -------------------------------
        From $this->sender.
        EOL;
    }



    public function mailHeader(): string
    {
        $timePassed = $this->date->diff(new \DateTime('now'));
        $timePassed = $timePassed->format('%d days ago');

        return "$this->sender sended a mail to you $timePassed.";
    }
}