<?php

namespace Minuz\Loing\Content\Stream;

use Minuz\Loing\Content\StreamFile\StreamFile;

abstract class Stream
{
    public readonly StreamFile $VideoFile;
    public readonly string $postDate;

    public readonly string $link;
    protected int $views = 0;
    public readonly string $publihser;
    
    abstract public function thumbnail(): string;



    public function __construct(StreamFile $VideoFile, string $link, string $publihser)
    {
        $this->VideoFile = $VideoFile;
        $this->link = $link;
        $this->publihser = $publihser;

        $postDate = new \DateTime("now");
        $this->postDate = $postDate->format("d/m/Y");
    }




    public function viewing(): string
    {
        $this->views++;
        return $this->VideoFile->content;
    }



    public function views(): string
    {
        return "$this->views";
    }
}