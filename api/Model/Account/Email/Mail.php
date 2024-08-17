<?php

namespace Minuz\Api\Model\Account\Email;


class Mail
{
    private \DateTimeImmutable $date;

    public function __construct(
        private string $sender,
        private string $reciever,
        private string $text,
                string $date
    ) {
        $this->date = new \DateTimeImmutable($date);
    }



    private function formatDate(): string
    {
        return $this->date->format('d/m/Y');
    }



    public function read(): array
    { 
        $mail = [
            'date' => $this->date->format('Y-m-d'),
            'sender' => $this->sender,
            'reciever' => $this->reciever,
            'text' => $this->text
        ];

        return $mail;
    }
}