<?php

namespace Minuz\Loing\Infrastructure\Repository\Queries;

class RepositoryQueries
{
// SEARCH VIDEOS QUERY
// --------------------------------------------
    public const SEARCH_QUERY = "
    SELECT
        search.Link
    FROM
        loingdb.search_map search

    WHERE
        search.Title LIKE '%{ | }%'
    OR
        search.Hashtags LIKE '%{ | }%'
    OR
        search.Channel LIKE '%{ | }%'
    ;
    
    ";



    public const SEARCH_VIDEO_QUERY = 
    "
    SELECT
        search.Title,
        search.Channel,
        search.Hashtags,
        search.Link,
        
        videos.VideoFile,
        
        interaction.Views,
        interaction.Likes,
        interaction.Dislikes
    FROM
        loingdb.videos videos

    LEFT JOIN
        loingdb.search_map search
    ON 
        search.Link = videos.Link

    LEFT JOIN
        loingdb.interaction interaction
    ON
        interaction.Link = videos.Link

    WHERE
        videos.Link = '{ | }'
    ;
    ";
    // -------------------------------------------------------


    public const SEARCH_VIDEO_COMMENTS = 
    "
    SELECT Publisher, Comment, CommentDate FROM loingdb.comments
    WHERE Link = '{ | }'
    ;	
    ";



    // UPLOAD VIDEO QUERIES
    // -------------------------------------------------------
    public const UPLOAD_VIDEO_QUERY = 
    "
    INSERT INTO loingdb.videos (Link, VideoFile)
    VALUES
    ('{ link }', '{ video }')
    ;
    INSERT INTO loingdb.comments (Link)
    VALUES ('{ link }')
    ;
    INSERT INTO loingdb.interaction (Link)
    VALUES ('{ link }')
    ;

    ";



    public const UPLOAD_SEARCH_MAP_QUERY = "
    INSERT INTO loingdb.search_map (Link, Title, Channel, Hashtags)
    VALUES
    ('{ | }', '{ | }', '{ | }', '{ | }')
    ;

    ";
    // -------------------------------------------------------



    public static function searchQuery(string $searchTerm): string
    {
        $query = str_replace('{ | }', $searchTerm, self::SEARCH_QUERY);
        
        return $query;
    }



    public static function searchVideoQuery(string $link): string
    {
        $query = str_replace('{ | }', $link, self::SEARCH_VIDEO_QUERY);

        return $query;
    }



    public static function searchCommentVideoQuery(string $link): string
    {
        $query = str_replace('{ | }', $link, self::SEARCH_VIDEO_COMMENTS);

        return $query;
    }



    public static function uploadQuery(array $video): string
    {
        $videoData = [$video['Link'], $video['VideoFile']];
        $searchMapData = [$video['Link'], $video['Title'], $video['Channel'], $video['Hashtags']];

        $videoFileQuery = str_replace('{ link }', $videoData['Link'], self::UPLOAD_VIDEO_QUERY);
        $videoFileQuery = str_replace('{ vieo }', $videoData['VideoFile'], self::UPLOAD_VIDEO_QUERY);
        
        $searchMapQuery = str_replace('{ | }', $searchMapData, self::UPLOAD_SEARCH_MAP_QUERY);

        $videoQuery = $videoFileQuery . $searchMapQuery;
        
        return $videoQuery;
    }
}