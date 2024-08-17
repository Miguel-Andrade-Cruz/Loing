<?php

namespace Minuz\Api\Tools;

class Validator
{
    public static function HydrateNulls(array $data, mixed $filling): array
    {
        $filler = function ($item) use ($filling) {
            return is_null($item) ? $filling : $item;
        };

        return array_map($filler, $data);
    }



    public static function HaveNullVaLues(array $data): bool
    {
        foreach ( $data as $item ) {
            if ( $item == null ) { return true; }
        }

        return false;
    }
}