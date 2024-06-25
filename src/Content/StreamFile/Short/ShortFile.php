<?php

namespace Minuz\Loing\Content\StreamFile\Short;

use Minuz\Loing\Content\StreamFile\StreamFile;

class ShortFile extends StreamFile
{
    // public readonly string $title;
    // public readonly string $description;
    // public readonly DateTime $postDate;
    // public readonly string $content;



    public function __construct(string $title, string $description, string $content)
    {
        parent::__construct($title, $description, $content);
    }
}