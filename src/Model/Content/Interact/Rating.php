<?php

namespace Minuz\Loing\Model\Content\Interact;


class Rating
{
    protected int $likes;
    protected int $dislikes;


    public function __construct(int $likes, int $dislikes)
    {
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }



    public function __tostring()
    {
        return <<<EOL
        $this->likes Likes +-+ $this->dislikes Dislikes
        EOL;
    }



    public function likeIt()
    {
        $this->likes++;
    }



    public function dislikeIt()
    {
        $this->dislikes++;
    }
}