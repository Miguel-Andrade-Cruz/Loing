<?php

namespace Minuz\Loing\Model\Files;

class Video extends File
{
    public const FILE_EXTENSION = '.mp4';

    protected string $content;



    public function __construct(string $name, string $content)
    {
        parent::__construct($name, $content);
    }



    public function __tostring()
    {
        return <<<EOL
        $this->name

        = = = = = = = = = = = = = =
        $this->content
        EOL;
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



    public function content(): string
    {
        return $this->content;
    }
}