<?php

namespace Minuz\Loing\Content\Interaction;

use Minuz\Loing\Content\Stream\Text\Comment;

class BasicInteraction
{
    protected \SplStack $commentSection;

    protected int $likes = 0;
    protected int $dislikes = 0;



    public function __construct()
    {
    }



    public function newComment(Comment $comment): void
    {
        $this->commentSection[$comment->publisher] = $comment;
    }



    public function like(): void
    {
        $this->likes++;
    }



    public function dislike(): void
    {
        $this->dislikes++;
    }



    public function balance(): string
    {
        return "$this->likes Likes | $this->dislikes Dislikes";
    }
}