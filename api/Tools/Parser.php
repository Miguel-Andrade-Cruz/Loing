<?php

namespace Minuz\Api\Tools;

class Parser
{
    public static function treatURI(string $uri): array
    {
        $roughUriData = parse_url($uri);
        $roughPath = $roughUriData['path'];
        $routePath = $roughUriData['path'];
        
        preg_match('~\/[\w]+\/[\w]+\/([\w\d]+)~', $roughPath, $matches);
        $id = $matches[1] ?? false;
        
        $stringQueries = $roughUriData['query'] ?? false;
        
        $queriesPair = ! $stringQueries ? [] : explode('&', $stringQueries);
        
        $queries = [];
        foreach ( $queriesPair as $param => $queriePair ) {
            [$param, $value] = explode('=', $queriePair);
            $queries[$param] = $value;
            
        }
        
        $queries = empty($queries) ? false : $queries;
        

        if ( $id ) {
            $routePath = str_replace($id, '{id}/', $roughUriData['path']);
        }

        $uriData = [
            'route path' => $routePath,
            'id' => $id,
            'queries' => $queries
        ];

        return $uriData;
    }
}