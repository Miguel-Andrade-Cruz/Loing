<?php

namespace Minuz\Api\Responser;

class Responser
{
    public static function Response(array $data)
    {
        header('Content-type: application/json');
        $json = json_encode($data);

        echo $json;
    }
}