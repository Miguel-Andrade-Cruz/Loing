<?php

namespace Minuz\Loing\Features;

interface Likeable
{
    public function like(): void;

    public function dislike(): void;
}