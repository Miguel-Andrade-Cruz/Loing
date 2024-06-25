<?php

namespace Minuz\Loing\Content\Stream;

use Minuz\Loing\Features\Likeable;

use Minuz\Loing\Content\Interaction\BasicInteraction;
use Minuz\Loing\Content\StreamFile\StreamFile;

class Short extends Stream implements Likeable
{
    // public readonly StreamFile $VideoFile;
    public BasicInteraction $ViewersInteraction;

    // protected string $link;
    // protected int $views;


    public function __construct(StreamFile $VideoFile, string $link, string $publisher)
    {
        parent::__construct($VideoFile, $link, $publisher);
        $this->ViewersInteraction = new BasicInteraction();
    }



    public function like(): void
    {
        $this->ViewersInteraction->like();
    }



    public function dislike(): void
    {
        $this->ViewersInteraction->dislike();
    }



    public function thumbnail(): string
    {
        $title = $this->VideoFile->title;
        $balance = $this->ViewersInteraction->balance();

        return <<<EOL
        $title

        $balance || $this->views Views
        EOL;
    }
}