<?php

namespace Minuz\Loing\User\Account;

use Minuz\Loing\User\Account\Account;
use Minuz\Loing\Content\StreamFile\StreamFile;
use Minuz\Loing\LoingApp\LoingApp;

class Producer extends Account
{
    protected \SplStack $library;

    protected \SplStack $productionLibrary;

    public function __construct(string $nickName, string $emailAdress, string $password)
    {
        parent::__construct($nickName, $emailAdress, $password);
    }



    public function createVideo(StreamFile $video, string $videoTitle): string
    {
        $this->productionLibrary[$videoTitle] = $video;

        return $videoTitle;
    }



    public function postVideo(string $videoTitle): void
    {
        $video = $this->productionLibrary[$videoTitle];

        $linkage = LoingApp::upload($video, $this->nickName);
        $this->library[$video->title] = $linkage;
    }
}