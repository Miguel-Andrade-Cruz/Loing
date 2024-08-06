<?php

namespace Minuz\Api\Model\Account\Email;


class Mail
{
    public readonly \DateTimeImmutable $date;


    public function __construct(
        public readonly string $sender,
        public readonly string $reciever,
        public readonly string $text,
        string $date
    ) {
        $this->date = new \DateTimeImmutable($date);
    }



    public function __tostring()
    {
        $date = $this->date->format('d/m/Y');

        return <<<EOL
        $this->sender Sended to you at $date:
        
        $this->text
        EOL;
    }
}