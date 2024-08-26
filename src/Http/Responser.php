<?php

namespace Minuz\Api\Http;

use Firebase\JWT\JWT;
use Minuz\Api\JWK\JWK;

class Responser
{
    public static function Response(int $code, string $warning = 'None', string $message = 'None', array $data = [], ?string $jwt = null)
    {
        header('Content-type: application/json', response_code: $code);
        if (  $jwt != null ) {
            header("Authorization: Bearer $jwt");
        }
        
        $data = array_merge(
            $data, ['Warning' => $warning, 'Status message' => $message]
        );
        
        $json = json_encode($data);

        echo $json;
    }
}