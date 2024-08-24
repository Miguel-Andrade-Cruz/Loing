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

        $queries = Validator::HaveValues($searchQueries, ['q']);
        
        if ( ! $searchQueries['q'] ) {
            $this->emptySearchProcess($response);
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

        $video = $acc->searchByLink("www.loing.com/videos/$link");
        
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
        $response::Response(201, message: 'Video uploaded');
        
        return;
    }



    private function uploadErrorProcess(Responser $response): void
    {
        $response::Response(400, 'Error', 'Cannot upload: Malformed video or empty fields');
        return;
    }



    private function videoSearchedProcess(Responser $response, array $videosFound)
    {
        $response::Response(200, data: $videosFound);
        return;
    }



    private function videoNotFoundProcess(Responser $response)
    {
        $response::Response(400, 'Issue', 'Video not found');
        return;
    }



    private function loginRequiredProcess(Responser $response): void
    {
        $response::Response(401, 'Error', 'You need to login before search for videos.');
        return;
    }



    private function emptySearchProcess(Responser $response)
    {
        $response::Response(401, 'Eror', 'Empty field of search');
        return;
    }
}