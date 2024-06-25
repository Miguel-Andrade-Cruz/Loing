<?php

namespace Minuz\Loing\Features;

use Minuz\Loing\Content\Stream\Text\Comment;

interface Commentable
{
    public function addComment(Comment $comment): void;
}