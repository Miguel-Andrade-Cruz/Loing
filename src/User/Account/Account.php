<?php

namespace Minuz\Loing\User\Account;

use Minuz\Loing\Content\Stream\Stream;
use Minuz\Loing\User\Email\Email;

class Account
{
    protected string $nickName;
    protected Email $email;
    
    protected \SplStack  $gallery;


    public function __construct(string $nickName, string $emailAdress, string $password)
    {
        $this->nickName = $nickName;
        $this->email = new Email($emailAdress, $password);
    }



    public function __toString()
    {
        return $this->nickName;
    }



    public function changeNickName(string $newNickName, string $email, string $password): void
    {
        if ( ! $this->validate($email, $password) ) {
            throw new \DomainException("Alteração negada: Dados de conta inválidos.");
        }

        $this->nickName  = $newNickName;
        
        return;
    }



    public function validate($emailAdress, $password): bool
    {
        return $this->email->validate($emailAdress, $password);
    }



    public function play(Stream $video): string
    {
        return $video->viewing();
    }
}