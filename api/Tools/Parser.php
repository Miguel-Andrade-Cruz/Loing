<?php

namespace Minuz\Api\Tools;

class Parser
{
    public static function parseURI(string $uri): array
    {
        $roughUriData = parse_url($uri);
        $routePath = $roughUriData['path'];
        
        preg_match('~\/[\w]+\/[\w]+\/([\w\d]+)~', $routePath, $matches);
        $id = $matches[1] ?? false;
        
        if ( $id ) {
            $routePath = str_replace($id, '{id}', $routePath);
        }
        
        if ( ! isset($roughUriData['query'])) { 
            return [
                'route path' => $routePath,
                'id' => $id,
                'queries' => []
            ];
        }
        
        if ( empty($roughUriData['query']) ) {
            return [
                'route path' => $routePath,
                'id' => $id,
                'queries' => false
            ];
        }
        
        parse_str($roughUriData['query'], $queries);
        
        $routePath .= "?{query}";
        return [
            'route path' => $routePath,
            'id' => $id,
            'queries' => $queries
        ];
    }
}