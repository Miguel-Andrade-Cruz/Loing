<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;
use Minuz\Api\Model\Account\Account;
use Minuz\Api\Model\Video\Video;
use Minuz\Api\Tools\LinkGenerator;
use Minuz\Api\Tools\Validator;

session_start();

class VideoController
{
    public function __construct() { }


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



    public function link(Requester $request, Responser $response, string $link): void
    {
        if ( ! isset($_SESSION['email'], $_SESSION['nickname']) ) {
            $this->loginRequiredProcess($response);
            return;
        }

        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);

        $video = $acc->searchByLink($link);
        
        if ( ! $video ) {
            $this->videoNotFoundProcess($response);
            return;
        }

        $this->videoSearchedProcess($response, $video);
        return;
    }



    public function publish(Requester $request, Responser $response): void
    {
        if ( ! isset($_SESSION['email'], $_SESSION['nickname']) ) {
            $this->loginRequiredProcess($response);
            return;
        }

        $data = $request::body();

        if ( Validator::HaveNullVaLues($data) ) {
            $this->uploadErrorProcess($response);
            return;
        }


        $acc = new Account($_SESSION['email'], $_SESSION['nickname']);
        $video = new Video(
            $data['Title'],
            $data['Content'],
            $acc->nickName,
            LinkGenerator::generateLink()
        );

        $acc->publish($video);

        $this->uploadCompletedProcess($response);
        return;
    }



    private function uploadCompletedProcess(Responser $response): void
    {
        $responseData = [
            'Status message' => 'Video uploaded',
            'Warining' => 'None',
        ];

        $response::Response($responseData, 201);
        
        return;
    }



    private function uploadErrorProcess(Responser $response): void
    {
        $responseData = [
            'Status message' => 'Cannot upload: Malformed video or empty fields',
            'Warining' => 'Error',
        ];

        $response::Response($responseData, 400);
        
        return;
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
            'Warning' => 'You need to login before search for videos.'
        ];
        $response::Response($responseData, 401);
        return;
    }
}