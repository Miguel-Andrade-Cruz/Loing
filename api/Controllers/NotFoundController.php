<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;


class NotFoundController
{
    public function index(Requester $request, Responser $response)
    {
        $response_info = [
            'Status Message' => 'Error',
            'Warning' => 'Path not found'
        ];

        $response::Response($response_info, 404);
    }
}