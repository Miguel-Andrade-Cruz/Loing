<?php

namespace Minuz\Loing\Video;

use Minuz\Loing\Interactions\Rating\Rating;

class Video
{
    public readonly string $title;
    public readonly string $channel;

    protected \SplStack $comments;
    protected array $hashtags;
    protected Rating $videoRating;

    protected string $link;

    public readonly string $videoFile;


    public function __construct(
        string $title,
        string $channel,
        \SplStack $comments,
        array $hashtags,
        Rating $videoRating,
        string $videoFile,
        string $link
        ) {
        $this->title = $title;
        $this->channel = $channel;
        
        $this->comments = $comments;
        $this->hashtags = $hashtags;
        $this->videoRating = $videoRating;

        $this->link = $link;

        $this->videoFile = $videoFile;
    }



    public function __toString()
    {
        $commentSection = '';
        foreach ( $this->comments as $comment ) {
            $commentSection .= $comment;
        }


        return <<<EOL
        $this->title
        ------------------------------------------

        $this->videoFile
        
        |||||||||||||||||  COMMENTS  ||||||||||||||||||
        
        $commentSection
        EOL;


    }



    public function thumbnail(): string
    {
        return <<<EOL
        
        
        EOL;
    }
}