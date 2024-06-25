<?php

namespace Minuz\Loing\Content\Stream;

use Minuz\Loing\Features\{Commentable, Likeable};

use Minuz\Loing\Content\Interaction\BasicInteraction;
use Minuz\Loing\Content\Stream\Text\Comment;
use Minuz\Loing\Content\StreamFile\StreamFile;

class Video extends Stream implements Commentable, Likeable
{
    // public readonly StreamFile $VideoFile;
    public BasicInteraction $ViewersInteraction;

    // protected string $link;
    // protected int $views;
    

    public function __construct(StreamFile $VideoFile, string $link, string $publihser)
    {
        parent::__construct($VideoFile, $link, $publihser);
        $this->ViewersInteraction = new BasicInteraction();
    }




    public function addComment(Comment $comment): void
    {
        $this->ViewersInteraction->newComment($comment);
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