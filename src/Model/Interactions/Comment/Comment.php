<?php

namespace Minuz\Loing\Model\Interactions\Comment;

class Comment
{
    public readonly string $publisher;
    protected string $comment;
    protected \DateTime $postDate;



    public function __construct(string $publisher, string $comment, string $postDate)
    {
        $this->publisher = $publisher;
        $this->comment = $comment;
        $this->postDate = new \DateTime($postDate);
    }



    public function __toString()
    {
        $pastTime = $this->postDate->diff(new \DateTime('now'));
        $pastTime = $pastTime->format('%d days ago');
        
        return <<<EOL
        
        | $this->publisher said $pastTime:
        |
        | $this->comment


        EOL;
    }


    public function edit(string $newComment): void
    {
        $this->comment = $newComment;
        $this->postDate = new \DateTime('now');

        return;
    }
}