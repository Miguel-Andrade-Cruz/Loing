<?php
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

ini_set('mysql.connection_timeout', 300);
ini_set('default_socket_timeout', 300);