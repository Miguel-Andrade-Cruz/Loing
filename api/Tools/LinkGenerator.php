<?php

namespace Minuz\Api\Tools;

class LinkGenerator
{
    public static function generateLink()
    {
        $chars = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'));
        $size = 12;

        $link = "";
        for ($unit = 0; $unit < $size; $unit++) {
            $randomChar = mt_rand(0, count($chars) - 1);
            $link .= $chars[$randomChar];
        }

        return $link;
    }
}