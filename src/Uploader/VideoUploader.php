<?php

namespace Minuz\Loing\Uploader;

use Minuz\Loing\VideoFile\Video as VideoFile;

class VideoEncoder
{
    public static function mp4Encoder(VideoFile $video, string $title,  array $hashtags, string $channel): array
    {
        $hashtags = implode('  ', $hashtags);

        $videoEconded = [
            'Title' => $title,
            'Channel' => $channel,
            'Hashtags' => $hashtags,
            'VideoFile' => $video->content
        ];

        return $videoEconded;
    }
}