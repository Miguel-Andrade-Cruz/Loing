<?php

namespace Minuz\Loing\Content\Stream\Text;

class Comment
{
    public readonly string $publisher;

    public readonly string $text;

    public function __construct(string $publisher, string $text)
    {
        $this->publisher = $publisher;
        $this->text = $text;
    }



    public function __toString(): string
    {
        return <<<EOL
        $this->publisher:

        $this->text
        
        EOL;
    }
}