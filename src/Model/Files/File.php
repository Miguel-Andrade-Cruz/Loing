<?php

namespace Minuz\Loing\Model\Files;

abstract class File
{
    public const FILE_EXTENSION = '.any';

    protected string $name;

    protected string $content;



    abstract public function write(string $newContent);

    abstract public function clear();

    abstract public function compile(): array; 



    public function __construct(string $name, string $content)
    {
        $this->rename($name);
        $this->write($content);
    }



    public function __toString()
    {
        return $this->content;
    }



    public function rename(string $newName)
    {
        $this->name = $newName . static::FILE_EXTENSION;
    }
}