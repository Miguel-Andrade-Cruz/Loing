<?php

namespace Minuz\Api\Model\Account;

use Minuz\Api\Repository\DataCenter\DataCenter;
use Minuz\Api\Model\Account\Email\Email;
use Minuz\Api\Model\Video\Video;

class Account
{
    private DataCenter $cloud;

    protected Email $email;

    public readonly string $nickName;


    public function __construct(string $email, string $nickName)
    {
        $this->nickName = $nickName;
        $this->email = new Email($email);

        $this->cloud = new DataCenter();
    }



    public function publish(Video $video): bool
    {
        return $this->cloud->publish($video);
    }



    public function searchVideo(string $search): array
    {
        return $this->cloud->search($search);
    }



    public function searchByLink(string $link) {
        return $this->cloud->searchByLink($link);
    }



    public function email(): string
    {
        return $this->email;
    }



    public function viewAllMails(): array
    {
        return $this->email->viewAllMails();
    }



    public function sendMail(string $reciever, string $text, string $date): void
    {
        $this->email->sendMail($reciever, $text, $date);
    }



    public function library(): array
    {
        $videos = $this->cloud->searchByChannel($this->nickName);

        return $videos;
    }
}