<?php

namespace Minuz\Loing\Model\Interactions\Rating;

class Rating
{
    protected int $likes;
    protected int $dislikes;

    public function __construct(?int $likes, ?int $dislikes = 0)
    {
        $this->likes = $likes ?? 0;
        $this->dislikes = $dislikes ?? 0;
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