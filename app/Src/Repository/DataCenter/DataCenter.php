<?php

namespace Minuz\Api\Repository\DataCenter;

use Minuz\Api\COnfig\Connection\ConnectionCreator;
use Minuz\Api\Model\Video\Rating\Rating;
use Minuz\Api\Model\Video\Video;

class DataCenter
{
    private static \PDO $pdo;


    public function __construct()
    {
        self::$pdo = ConnectionCreator::connect();
    }



    public function publish(Video $video): bool
    {
        self::$pdo->prepare(self::$RATING_ADD_QUERY)->execute([
            ':link' => $video->link
        ]);
        $stmt = self::$pdo->prepare(self::$PUBLISH_VIDEO_QUERY);
        return $stmt->execute([
            ':title' => $video->title,
            'link' => $video->link,
            ':content' => $video->content,
            ':channel' => $video->channel
        ]);
    }



    public function search(string $search): array
    {
        $stmt = self::$pdo->prepare(self::$SEARCH_VIDEO_QUERY);
        $stmt->execute([':search' => '%' .$search. '%']);

        $videosFound = [];
        while ($videoData = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rating = new Rating($videoData['likes'], $videoData['dislikes']);
            $video = new Video(
                $videoData['Title'],
                $videoData['Content'],
                $videoData['Channel'],
                $videoData['Link'],
                $rating
            );
            $videosFound[] = [
                'Title' => $video->title,
                'Content' => $video->content,
                'Channel' => $video->channel,
                'Link' => $video->link,
                'Rating' => $video->rating->viewRating()
            ];
        }

        return $videosFound;
    }



    public function searchByChannel(string $channel): array|bool
    {
        $stmt = self::$pdo->prepare(self::$SEARCH_BY_CHANNEL_QUERY);
        $stmt->execute([
            ':channel' => $channel
        ]);

        $videosFound = [];
        while ($videoData = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rating = new Rating($videoData['likes'], $videoData['dislikes']);
            $video = new Video(
                $videoData['Title'],
                $videoData['Content'],
                $videoData['Channel'],
                $videoData['Link'],
                $rating
            );
            $videosFound[] = [
                'Title' => $video->title,
                'Content' => $video->content,
                'Channel' => $video->channel,
                'Link' => $video->link,
                'Rating' => $video->rating->viewRating()
            ];
        }

        return $videosFound;
    }



    public function searchByLink(string $link): array|bool {
        $stmt = self::$pdo->prepare(self::$SEARCH_BY_LINK_QUERY);

        $stmt->execute([
            ':link' => $link
        ]);
        $videoData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ( ! $videoData ) {
            return false;
        }

        $rating = new Rating($videoData['likes'], $videoData['dislikes']);
        $video = new Video(
            $videoData['Title'],
            $videoData['Content'],
            $videoData['Channel'],
            $videoData['Link'],
            $rating
        );

        return [
            'Title' => $video->title,
            'Content' => $video->content,
            'Channel' => $video->channel,
            'Link' => $video->link,
            'Rating' => $video->rating->viewRating()
        ];
    }


    private static string $RATING_ADD_QUERY = 
    "
    INSERT INTO loingdb.rating (link)
    VALUES (:link);
    "
    ;

    private static string $PUBLISH_VIDEO_QUERY = 
    "
    INSERT INTO loingdb.videos (Title, Content, Link, Channel)
    VALUES 
    (:title, :content, :link, :channel);
    "
    ;



    private static string $SEARCH_VIDEO_QUERY =
    "
    SELECT
        videos.Title,
        videos.Channel,
        videos.Link,    
        videos.Content,
	    videos.Views,
        rating.likes,
        rating.dislikes
        
    FROM
	    loingdb.videos videos
    LEFT JOIN
	    loingdb.rating rating
    ON
	    rating.link = videos.Link
        
    WHERE
        videos.Title LIKE :search
    OR	videos.Channel LIKE :search
        ;
        "
        ;


    private static string $SEARCH_BY_LINK_QUERY = 
    "
    SELECT
        videos.Title,
        videos.Channel,
        videos.Link,    
        videos.Content,
	    videos.Views,
        rating.likes,
        rating.dislikes
        
    FROM
	    loingdb.videos videos
    LEFT JOIN
	    loingdb.rating rating
    ON
	    rating.link = videos.Link
        
    WHERE
        videos.Link = :link
    ;
    "
    ;


    private static string $SEARCH_BY_CHANNEL_QUERY = 
    "
    SELECT
        videos.Title,
        videos.Channel,
        videos.Link,    
        videos.Content,
	    videos.Views,
        rating.likes,
        rating.dislikes
        
    FROM
	    loingdb.videos videos
    LEFT JOIN
	    loingdb.rating rating
    ON
	    rating.link = videos.Link
        
    WHERE
        videos.Channel = :channel
    ;
    ";
}