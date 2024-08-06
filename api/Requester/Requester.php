<?php

namespace Minuz\Api\Requester;

class Requester
{
    private static ?string $method;
    private static ?string $service;
    private static ?string $endpoint;
    private static ?string $id;
    private static ?array $data;


    public function __construct()
    {
        self::process();
    }



    public static function Request(): array
    {
        return [
            'endpoint' => self::$endpoint,
            'id'       => self::$id,
            'data'     => self::$data,
        ];
    }



    public static function Route(): string
    {
        $method = self::$method;
        $service = self::$service;
        
        return "$method || $service";
    }



    private static function process()
    {
        $uri = $_SERVER['REQUEST_URI'];
        preg_match_all('~\/[\w]{1,}~', $uri, $info);
        $info = $info[0];

        self::$method = $_SERVER['REQUEST_METHOD'];
        
        self::$service = $info[0] ?? null;
        self::$endpoint = $info[1] ?? null;
        self::$id = $info[2] ?? null;

        self::$data = json_decode(file_get_contents('php://input'), true);
    }
}