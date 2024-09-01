<?php

namespace Minuz\Api\Http;

class Responser
{
    public static function Response(int $code, string $warning = 'None', string $message = 'None', array $data = [], ?string $jwt = null)
    {
        header('Content-type: application/json', response_code: $code);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization, Content-Type");

        if (  $jwt != null ) {
            header("Authorization: Bearer $jwt");
        }
        
        $data = array_merge(
            ['Warning' => $warning, 'Status message' => $message], $data
        );
        
        $json = json_encode($data);

        echo $json;
    }
}