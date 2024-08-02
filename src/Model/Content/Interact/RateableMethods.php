<?php

namespace Minuz\Loing\Model\Content\Interact;


trait RateableMethods
{
    public function likeIt(): void 
    {
        $this->rating->likeIt();
    }



    public function dislikeIt(): void
    {
        $this->rating->dislikeIt();
    }
    

}