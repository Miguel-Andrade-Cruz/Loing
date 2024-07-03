<?php

namespace Minuz\Loing\VideoFile;

use Minuz\Loing\File\File;

class Video extends File
{
    public const EXTENSION = '.mp4';

    public string $content;



    public function __construct(string $filename, string $content)
    {
        parent::__construct($filename);
        $this->write($content);
    }



    public function write(string $newContent): void
    {
        $this->content = $newContent;
    }
}