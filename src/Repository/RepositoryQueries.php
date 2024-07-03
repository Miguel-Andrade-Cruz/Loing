<?php

namespace Minuz\Loing\REpository;

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
        
        interaction.views,
        interaction.likes,
        interaction.dislikes,
        
        comments.Publisher,
        comments.Comment,
        comments.CommentDate
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

    LEFT JOIN
        loingdb.comments comments
    ON
        comments.Link = search.Link

    WHERE
        videos.Link = '{ | }'
    ;
    ";
// -------------------------------------------------------




// UPLOAD VIDEO QUERIES
// -------------------------------------------------------
public const UPLOAD_VIDEO_QUERY = 
"
INSERT INTO loingdb.videos (Link, VideoFile)
VALUES
('$link', '$content')
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



    public static function searchByLinkQuery(string $link): string
    {
        $query = str_replace('{ | }', $link, self::SEARCH_VIDEO_QUERY);

        return $query;
    }



    public static function uploadQuery(array $video): string
    {
        $videoData = [$video['Link'], $video['VideoFile']];
        $searchMapData = [$video['Link'], $video['Title'], $video['Channel'], $video['Hashtags']];

        $videoFileQuery = str_replace('{ | }', $videoData, self::UPLOAD_VIDEO_QUERY);
        $searchMapQuery = str_replace('{ | }', $searchMapData, self::UPLOAD_SEARCH_MAP_QUERY);

        $videoQuery = $videoFileQuery . $searchMapQuery;
        
        return $videoQuery;
    }
}