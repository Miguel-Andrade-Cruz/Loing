<?php

namespace Minuz\Loing\User;

use Minuz\Loing\Content\Stream\Stream;
use Minuz\Loing\User\Account\Account;
use Minuz\Loing\User\Account\{Viewer, Producer};
use Minuz\Loing\Content\StreamFile\StreamFile;

class User
{
    protected string $Name;

    protected Viewer|Producer|false $activeAccount = false;
    protected array $accounts = [];


    public function __construct(string $Name, Account $account)
    {
        $this->Name = $Name;
        $this->accounts[$account->__toString()] = $account;
        $this->activeAccount = $account;
    }



    public function createAccount(string $nickName, string $email, string $password): void
    {
        $account = new Account($nickName, $email, $password);
        $this->accounts[$account->__toString()] = $account;

        return;
    }



    public function Login(string $nickName, string $email, string $password): void
    {
        if ( ! array_key_exists($nickName, $this->accounts) ) {
            throw new \DomainException("Essa conta não existe.");
        }

        $account = $this->accounts[$nickName];

        if ( ! $account->validate($email, $password) ) {
            throw new \DomainException("Acesso negado: senha incorreta.");
        };

        $this->activeAccount = $account;

        return;
    }



    public function Logout(): void
    {
        $this->activeAccount = false;
    }



    public function nickName(): string
    {
        return $this->activeAccount;
    }



    public function createVideo(StreamFile $video, string $videoTitle): void
    {
        if ( ! $this->activeAccount instanceof Producer ) {
            throw new \DomainException("ua conta não permite postar vídeos.");
        }
        
        $this->activeAccount->createVideo($video, $videoTitle);
    }
    
    
    
    public function postVideo(string $videoTitle): void
    {
        if ( ! $this->activeAccount instanceof Producer ) {
            throw new \DomainException("ua conta não permite postar vídeos.");
        }

        $this->activeAccount->postVideo($videoTitle);
    }



    public function play(Stream $video): string
    {
        return $this->activeAccount->play($video);
    }
}


