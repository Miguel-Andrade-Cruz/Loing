<?php

namespace Minuz\Loing\Model\Content\Interact;

class Comment
{
    use RateableMethods;

    protected string $text;
    protected Rating $rating;


    public function __construct(string $text, int $likes, int $dislikes)
    {
        $this->text = $text;
        $this->rating = new Rating($likes, $dislikes);
    }
}