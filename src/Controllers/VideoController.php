<?php

namespace Minuz\Api\Controllers;

use Minuz\Api\Http\Requester;
use Minuz\Api\Http\Responser;
use Minuz\Api\Model\Account\Account;
use Minuz\Api\Model\Video\Video;
use Minuz\Api\Tools\LinkGenerator;
use Minuz\Api\Tools\Validator;


class VideoController extends LoginRequiredController
{
    public function __construct() { }


    public function search(Requester $request, Responser $response, string $id = null, array $searchQueries): void
    {
        $validQueries = Validator::HaveValues($searchQueries, ['q']);
        if ( ! $validQueries['q'] ) {
            $this->emptySearchProcess($response);
            return;
        }

        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }

        $acc = new Account($session->email, $session->nickname);
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
        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }

        $acc = new Account($session->email, $session->nickname);

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
        if ( ! $session = $this->loginSession($request, $response) ) {
            return;
        }

        $data = $request::body();

        if ( Validator::HaveNullVaLues($data) ) {
            $this->uploadErrorProcess($response);
            return;
        }


        $acc = new Account($session->email, $session->nickname);
        $video = new Video(
            $data['Title'],
            $data['Content'],
            $acc->nickName,
            LinkGenerator::generateLink()
        );

        $acc->publish($video);

        $this->uploadCompletedProcess($response, $video);
        return;
    }



    private function uploadCompletedProcess(Responser $response, Video $video): void
    {
        $response::Response(201, 'None', 'Video uploaded', ['video link' => $video->link]);
        
        return;
    }



    private function uploadErrorProcess(Responser $response): void
    {
        $response::Response(400, 'Error', 'Cannot upload: Malformed video or empty fields');
        return;
    }



    private function videoSearchedProcess(Responser $response, array $videosFound)
    {
        $response::Response(200, data: ['Data' => $videosFound]);
        return;
    }



    private function videoNotFoundProcess(Responser $response)
    {
        $response::Response(400, 'Issue', 'Video not found');
        return;
    }



    private function emptySearchProcess(Responser $response)
    {
        $response::Response(401, 'Eror', 'Empty field of search');
        return;
    }
}