<?php

namespace Minuz\Api\Model\Video\Rating;

class Rating
{
    public function __construct(private int $likes, private int $dislikes) { }


    public function likeIt()
    {
        $this->likes++;
    }
    
    
    
    public function dislikeIt()
    {
        $this->dislikes++;
    }



    public function viewRating(): array
    {
        return [
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];
    }
}