<?php

namespace Minuz\Loing\Model\File;

abstract class File
{
    public const EXTENSION = '.mix';
    
    protected string $filename;


    public function __construct(string $filename)
    {
        $this->filename = $filename . static::EXTENSION;
    }
}