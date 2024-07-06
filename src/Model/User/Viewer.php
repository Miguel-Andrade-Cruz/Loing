<?php

namespace Minuz\Loing\Model\User;

use Minuz\Loing\Infrastructure\Repository\VideoRepository;
use Minuz\Loing\Model\User\Account\Account;
use Minuz\Loing\Model\Video\Video;

class Viewer extends Account
{
    // protected Email $email;
    // protected string $password;

    protected static VideoRepository $searcher;

    public function __construct(string $email, string $password, \SplStack $mailBox)
    {
        parent::__construct($email, $password, $mailBox);
        self::$searcher = new VideoRepository();
    }



    public function play(Video $video): string 
    {
        return $video;
    }



    public function search(string $searchTerm): Video|array
    {
        $videos = self::$searcher->search($searchTerm);
        
        $videosPreview = '';
        foreach ($videos as $thumb => $video) {
            $videosPreview .= $thumb . PHP_EOL;
        }
        echo $videosPreview;
        
        return $videos;
    }
}