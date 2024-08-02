<?php

namespace Minuz\Loing\DataBase\VideoServer;

use Minuz\Loing\Config\Connection\ConnectionCreator;
use Minuz\Loing\Model\Content\Video\Video;
use Minuz\Loing\Model\Files\Video as VideoFile;

class VideoServer
{
    private \PDO $pdo; 


    public function __construct()
    {
        $this->pdo = ConnectionCreator::connect();
    }



    public static function linkGenerator(string $channel): string
    {
        $characters = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        $urlLength = 8;

        $max = count($characters) -1;
        $url = "https://loing.com.br/$channel/";
        for ($char = 0; $char < $urlLength; $char++) {
            $url .= mt_rand(0, $max);
        }

        return $url;
    }



    public function upload(string $title, VideoFile $video, string $channel)
    {
        $link = self::linkGenerator($channel);

        $query = VideoServerQueries::upload($title, $video->content(), $link);

        $this->pdo->exec($query);
    }



    public function search(string $search): Video
    {
        $query = VideoServerQueries::search($search);

        $videoInfo = $this->pdo->query($query)->fetch(\PDO::FETCH_ASSOC);

        return new Video($videoInfo['Title'], $videoInfo['VideoFile'], $videoInfo['Link']);
    }
}