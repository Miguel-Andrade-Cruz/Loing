<?php

namespace Minuz\Loing\LoingApp;

use Minuz\Loing\Content\Stream\Short;
use Minuz\Loing\Content\Stream\Stream;
use Minuz\Loing\Content\Stream\Video;
use Minuz\Loing\Content\StreamFile\Short\ShortFile;
use Minuz\Loing\Content\StreamFile\StreamFile;

class LoingApp
{

    protected static array $AccountRepository;
    
    protected static \SplStack $VideoRepository;


    public static function upload(StreamFile $video, string $publihser): string
    {
        $link = 'https://loing.com/';
        
        $preparedVideo = match ($video) {
            
            $video->duration < 10 => self::shortVideoPrepare($link, $video, $publihser),
            $video->duration > 10 => self::videoPrepare($link, $video, $publihser)
        };
        self::$VideoRepository[$link] = $video;
        
        return $link;
    }
    
    
    
    private static function shortVideoPrepare(string &$link, $video, string $publisher): Stream
    {
        $link .= 'short/';
        $link .= self::linkCodeGenerator();
        $preparedVideo = new Short($video, $link, $publisher);
        
        return $preparedVideo;
    }
    
    
    
    public static function videoPrepare(string &$link, $video, string $publisher): Stream
    {
        $link .= 'video/';
        $link .= self::linkCodeGenerator();
        $preparedVideo = new Video($video, $link, $publisher);

        return $preparedVideo;
    }



    private static function linkCodeGenerator(): string
    {
        $urlLength = 8;

        $chars = array_merge(range('a', "z"), range('A', 'Z'), range('0', '9'));
        $max = count($chars) -1;

        $linkCode = "";
        for ( $i = 0; $i < $urlLength; $i++ ) {
            
            $randomChar = mt_rand(0, $max);
            $linkCode .= $chars[$randomChar];
        }

        return $linkCode;
    }
}