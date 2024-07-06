<?php

namespace Minuz\Loing\Infrastructure\Repository;

use Minuz\Loing\Infrastructure\Connection\Connection;
use Minuz\Loing\Infrastructure\Repository\Queries\RepositoryQueries;

use Minuz\Loing\Model\Interactions\Comment\Comment;
use Minuz\Loing\Model\Interactions\Rating\Rating;
use Minuz\Loing\Model\Video\Video;

class VideoRepository
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    public function upload(array $videoEncoded): void
    {
        
        $query = RepositoryQueries::uploadQuery($videoEncoded);

        $this->connection->exec($query);
    }



    public function search(string $searchTerm): Video|array
    {
        // If the searchTerm was a preivous link, send the exactly video
        if ( preg_match('~https:\/\/www\.loing\.com\.br\/videos\/[\w]{8}~', $searchTerm) ) {
            $video = self::linkSearch($searchTerm);
            return $video;
        }

        $query = RepositoryQueries::searchQuery($searchTerm);

        $statement = $this->connection->query($query);
        $videoLinksFound = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $videosFound = [];
        foreach ( $videoLinksFound as $videoLink ) {

            $video = self::linkSearch($videoLink['Link']);
            $videosFound[$video->thumbnail()] = $video;
        }

        return $videosFound;
    }



    private function linkSearch(string $link): Video
    {
        $videoQuery = RepositoryQueries::searchVideoQuery($link);
        $commentsQuery = RepositoryQueries::searchCommentVideoQuery($link);
        
        $videoStatement = $this->connection->query($videoQuery);
        $commentsStatement = $this->connection->query($commentsQuery);
        
        $videoData = $videoStatement->fetch(\PDO::FETCH_ASSOC);
        $commentVideoData = $commentsStatement->fetchAll(\PDO::FETCH_ASSOC);
        
        $video = self::videoMapper($videoData, $commentVideoData);

        return $video;
    }



    private static function videoMapper(array $videoData, array $commentsData): Video
    {
        $hashtags = explode('  ', $videoData["Hashtags"]);
        $rating = new Rating($videoData['Likes'], $videoData['Dislikes']);
        $commentSection = self::commentsMapper($commentsData);

        $video = new Video(
            $videoData['Title'],
            $videoData['Channel'],
            $commentSection,
            $hashtags,
            $rating,
            $videoData['VideoFile'],
            $videoData['Link']
        );

        return $video;
    }




    private static function commentsMapper(array $commentSection): \SplStack
    {
        if ( empty($commentSection) ) {
            return new \SplStack();
        }

        $commentsObjects = array_map(
            function ($comment) {
                return new Comment($comment['Publisher'], $comment['Comment'], $comment['CommentDate']);
            },
            $commentSection
        );
        
        $comments = new \SplStack();
        for( $i=0; $i<count($commentsObjects); $i++ ){
            
            $comments->add($i,$commentsObjects[$i]);
        }
        
        return $comments;
    }
}