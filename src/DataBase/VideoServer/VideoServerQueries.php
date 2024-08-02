<?php

namespace Minuz\Loing\DataBase\VideoServer;

use Minuz\Loing\Model\Files\Video as VideoFile;

class VideoServerQueries
{
    private const QUERY_UPLOAD = 
    "
    INSERT INTO loingdb.videos (Title, Link, VideoFile)
    VALUES ('{ title }', '{ link }', '{ videoFile }');
    "
    ;


    private const QUERY_SEARCH = 
    "
    SELECT Title, VideoFile, Link FROM loingdb.videos videos
    WHERE videos.Title LIKE '%{ search }%'
    OR videos.Link LIKE '%{ search }%';
    "
    ;


    public static function upload(string $title, string $video, string $link): string
    {
        $filledQuery = str_replace(['{ title }', '{ link }', '{ videoFile }'], [$title, $link, $video], self::QUERY_UPLOAD);
        
        return $filledQuery;
    }



    public static function search(string $searchTerm): string
    {
        $filledQuery = str_replace('{ search }', $searchTerm, self::QUERY_SEARCH);

        return $filledQuery;
    }
}