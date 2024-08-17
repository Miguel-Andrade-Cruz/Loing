<?php

namespace Minuz\Api\Repository\DataCenter;

use Minuz\Api\COnfig\Connection\ConnectionCreator;
use Minuz\Api\Config\PDOQueries\PDOQueries;
use Minuz\Api\Model\Video\Rating\Rating;
use Minuz\Api\Model\Video\Video;

class DataCenter
{
    private static \PDO $pdo;


    public function __construct()
    {
        self::$pdo = ConnectionCreator::connect();
    }



    public function search(string $search): array
    {
        $stmt = self::$pdo->prepare(PDOQueries::SEARCH_VIDEO_QUERY);
        $stmt->execute([':search' => '%' .$search. '%']);

        $videosFound = [];
        while ($videoData = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rating = new Rating($videoData['likes'], $videoData['dislikes']);
            $video = new Video(
                $videoData['title'],
                $videoData['content'],
                $videoData['link'],
                $rating
            );

            $videosFound[] = $video;
        }
        return $videosFound;
    }
}