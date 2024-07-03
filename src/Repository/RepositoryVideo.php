<?php

namespace Minuz\Loing\Repository;

use Minuz\Loing\Connection\Connection;
use Minuz\Loing\REpository\RepositoryQueries;

use Minuz\Loing\Interactions\Comment\Comment;
use Minuz\Loing\Interactions\Rating\Rating;
use Minuz\Loing\Video\Video;

class RepositoryVideo
{
    public static \PDO $pdo = Connection::connect('mysql:dbname=loingdb;host=127.0.0.1');


    public static function upload(array $videoEncoded): void
    {
        $videoEncoded['Link'] = self::linkGenerator();
        
        $query = RepositoryQueries::uploadQuery($videoEncoded);

        self::$pdo->exec($query);
    }



    public static function search(string $searchTerm): array
    {
        $query = RepositoryQueries::searchQuery($searchTerm);

        $statement = self::$pdo->query($query);
        $videoLinksFound = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $videosFound = [];
        foreach ( $videoLinksFound as $videoLink ) {

            $video = self::searchForLink($videoLink);
            $videosFound[$video->thumbnail()] = $video;
        }

        return $videosFound;
    }

    
    
    public static function searchForLink(string $link): Video
    {
        $query = RepositoryQueries::searchByLinkQuery($link);

        $statement = self::$pdo->query($query);
        $videoDataFound = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $commentsData = array_merge(
            $videoDataFound['Publisher'],
            $videoDataFound['Comment'],
            $videoDataFound['CommentDate']
        );

        $ratingData = array_merge(
            $videoDataFound['Likes'],
            $videoDataFound['Dislikes']
        );
        
        $videoData = array_merge(
            $videoDataFound['Title'],
            $videoDataFound['Channel'],
            $videoDataFound['Hashtags'],
            $videoDataFound['VideoFile'],
            $videoDataFound['Link']
        );
        $videoData = array_unique($videoData);
        
        $video = self::videoMapper($videoData, $commentsData, $ratingData);

        return $video;
    }



    public static function videoMapper(array $videoData, array $commentsData, array $ratingData): Video
    {
        $commentSection = self::commentsMapper($commentsData);
        $rating = self::ratingMapper($ratingData);

        $video = new Video(
            $videoData['Title'],
            $videoData['Channel'],
            $commentSection,
            $videoData['Hashtags'],
            $rating,
            $videoData['VideoFile'],
            $videoData['Link']
        );

        return $video;
    }



    private static function ratingMapper(array $ratingData): Rating
    {
        return new Rating($ratingData['Likes'], $ratingData['Dislikes']);
    }



    private static function commentsMapper(array $commentSection): \SplStack
    {
        $commentsObjects = array_map(
            function ($publisher, $comment, $postDate) {
                
                return new Comment($publisher, $comment, $postDate);
            },
            $commentSection['Publisher'],
            $commentSection['Comment'],
            $commentSection['CommentDate']
        );
        
        $comments = new \SplStack();
        for( $i=0; $i<count($commentsObjects); $i++ ){
            
            $comments->add($i,$commentsObjects[$i]);
        }
        
        return $comments;
    }



    private static function linkGenerator(): string
    {
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
        $urlLength = 8;
        
        $link = "htps://www.loing.com/videos/";
        for ( $i = 0; $i < $urlLength; $i++ ) {

            $randIndex = mt_rand(0, count($chars) -1);
            $link .= $chars[$randIndex];
        }

        return $link;

    }
}