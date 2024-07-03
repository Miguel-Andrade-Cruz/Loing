<?php

namespace Minuz\Loing\File;

class File
{
    public const EXTENSION = '.mix';
    
    protected string $filename;


    public function __construct(string $filename)
    {
        $this->filename = $filename . self::EXTENSION;
    }
}