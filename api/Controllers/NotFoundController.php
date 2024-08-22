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
            'Warning' => 'Path not found, try checking the queries or endpoints'
        ];

        $response::Response(404, 'Error', 'Path not found, try checking the queries or endpoints');
    }
}