<?php

namespace Minuz\Api\Http;

class Responser
{
    public static function Response(int $code, string $warning = 'None', string $message = 'None', array $data = [])
    {
        header('Content-type: application/json', response_code: $code);
        
        $data = array_merge(
            $data, ['Warning' => $warning, 'Status message' => $message]
        );
        
        $json = json_encode($data);

        echo $json;
    }
}