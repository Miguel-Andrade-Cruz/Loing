<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;
use Minuz\Api\Model\Account\Account;

session_start();

class VideoController
{
    public function __construct() { }



    public function videos()
    {

    }



    public function search(Requester $request, Responser $response, string $id = null, array $searchQueries): void
    {
        if ( ! isset($_SESSION['email'], $_SESSION['nickname']) ) {
            $this->loginRequiredProcess($response);
            return;
        }

        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);
        $videosFound = $acc->searchVideo($searchQueries['q']);
        
        if( empty($videosFound) ) {
            $this->videoNotFoundProcess($response);
            return;
        }
        
        $this->videoSearchedProcess($response, $videosFound);
        return;
    }


    public function publish()
    {

    }



    private function videoSearchedProcess(Responser $response, array $videosFound)
    {
        $responseData = [
            'Status message' => 'None',
            'Warning' => 'None',
            'Data' => $videosFound
        ];

        $response::Response($responseData, 400);
        return;
    }



    private function videoNotFoundProcess(Responser $response)
    {
        $responseData = [
            'Status message' => 'Video not found',
            'Warning' => 'Issue',
        ];

        $response::Response($responseData, 400);
        return;
    }


    private function loginRequiredProcess(Responser $response): void
    {
        $responseData = [
            'Status Message' => 'Error',
            'Warning' => 'You need to login before use your email.'
        ];
        $response::Response($responseData, 401);
        return;
    }
}