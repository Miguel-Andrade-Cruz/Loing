<?php

namespace Minuz\Loing\INteractions\Rating;

class Rating
{
    protected int $likes;
    protected int $dislikes;

    public function __construct(int $likes, int $dislikes)
    {
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }



    public function __toString()
    {
        return "| $this->likes Likes || $this->dislikes Dislikes |";
    }



    public function likeIt(): void
    {
        $this->likes++;
        
        return;
    }



    public function dislikeIt(): void
    {
        $this->dislikes++;

        return;
    }
}