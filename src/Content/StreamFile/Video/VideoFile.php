<?php

namespace Minuz\Loing\Content\StreamFile\Video;

use Minuz\Loing\Content\StreamFile\StreamFile;

class VideoFile extends StreamFile
{
    
    // public readonly string $title;
    // public readonly string $description;
    // public readonly DateTime $postDate;
    
    // protected int $views;
    protected static string $videoType = "video";



    public function __construct(string $title, string $description, string $content)
    {
        parent::__construct($title, $description, $content);
    }
}