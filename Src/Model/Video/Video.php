<?php

namespace Minuz\Api\Model\Video;
use Minuz\Api\Model\Video\Rating\Rating;

class Video
{
    public readonly string $link;

    public function __construct(
        public readonly string $title, 
        public readonly string $content, 
        public readonly string $channel, 
        string $link,
        public Rating $rating = new Rating()
    ) {
        $this->link = $link;
    }



    public function likeIt()
    {
        $this->rating->likeIt();
    }



    public function dislikeIt()
    {
        $this->rating->dislikeIt();
    }



    public function view(): string
    {
        return $this->content;
    }
}