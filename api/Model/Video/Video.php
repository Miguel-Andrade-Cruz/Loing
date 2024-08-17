<?php

namespace Minuz\Api\Model\Video;
use Minuz\Api\Model\Video\Rating\Rating;

class Video
{
    public readonly string $title;
    public readonly string $link;
    public readonly string $content;

    public Rating $rating;

    public function __construct(string $title, string $content, string $link, Rating $rating)
    {
        $this->title = $title;
        $this->link = $link;
        $this->content = $content;
        $this->rating = $rating;
    }



    public function likeIt()
    {
        $this->rating->likeIt();
    }



    public function dislikeIt()
    {
        $this->rating->dislikeIt();
    }



    public function thumbnail(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'rating' => $this->rating->viewRating(),
            'link' => $this->link,
        ];
    }



    public function view(): string
    {
        return $this->content;
    }
}