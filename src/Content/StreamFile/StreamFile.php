<?php

namespace Minuz\Loing\Content\StreamFile;

use DateTime;

abstract class StreamFile
{
    public readonly string $title;
    public readonly string $description;
    public readonly string $content;
    public readonly int $duration;
    

    public function __construct(string $title, string $description, string $content)
    {

        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->duration = strlen($content);
    }
}
// print ("olá mundo")