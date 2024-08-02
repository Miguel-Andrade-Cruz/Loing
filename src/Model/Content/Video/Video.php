<?php

namespace Minuz\Loing\Model\Content\Video;


class Video
{

    public readonly string $title;
    public readonly string $content;
    public readonly string $link;


    public function __construct(string $title, string $content, string $link)
    {
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
    }



    public function __tostring()
    {
        return <<<EOL
        $this->title
        - - - - - - - - - - - - - - - -
        
        $this->content
        = = = = = = = = = = = = = = = =
        EOL;
    }
}