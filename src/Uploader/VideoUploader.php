<?php

namespace Minuz\Loing\Uploader;

use Minuz\Loing\Model\VideoFile\Video as VideoFile;

class VideoEncoder
{
    public static function encode_mp4(VideoFile $video, string $title,  array $hashtags, string $channel): array
    {
        $hashtags = implode('  ', $hashtags);

        $videoEconded = [
            'Title' => $title,
            'Channel' => $channel,
            'Hashtags' => $hashtags,
            'VideoFile' => $video->content,
            'Link' => self::linkGenerator()
        ];

        return $videoEconded;
    }



    private static function linkGenerator(): string
    {
        $urlLength = 8;
        $chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
        $link = "https://www.loing.com/videos/";

        for ( $i = 0; $i < $urlLength; $i++ ) {
            $randIndex = mt_rand(0, count($chars) -1);
            $link .= $chars[$randIndex];
        }

        return $link;
    }
}