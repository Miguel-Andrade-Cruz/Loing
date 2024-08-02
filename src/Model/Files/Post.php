<?php

namespace  Minuz\Loing\Model\Files;

class Post extends File
{
    public const FILE_EXTENSION = '.txt';

    protected string $content;



    public function __construct(string $name, string $content)
    {
        parent::__construct($name, $content);
    }



    public function write(string $newContent)
    {
        $this->content = $newContent;
    }



    public function clear()
    {
        $this->content = '';
    }



    public function compile(): array
    {
        return 
        [
            'Content' => $this->content
        ]
        ;
    }
}