<?php

namespace Minuz\Api\controller;

abstract class Controller
{
    abstract protected function Processor();
    abstract protected function Hydrate(array $requestInfo);

    public function __construct(array $requestInfo)
    {
        static::Hydrate($requestInfo);
    }
}