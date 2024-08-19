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
        $haveQueries = isset($roughUriData['query']);
        
        if ( $id ) {
            $routePath = str_replace($id, '{id}', $roughUriData['path']);
        }

        $queriesPair = [];
        if ( ! $haveQueries ) {
            return [
                'route path' => $routePath,
                'id' => $id,
                'queries' => false
            ];
    
        }

        $queriesPair = explode('&', $roughUriData['query']);
        $routePath .= "?{query}";
        
        $queries = [];
        foreach ( $queriesPair as $param => $queriePair ) {
            [$param, $value] = explode('=', $queriePair);
            $queries[$param] = $value;
            
        }
        
        return [
            'route path' => $routePath,
            'id' => $id,
            'queries' => $queries
        ];
    }
}