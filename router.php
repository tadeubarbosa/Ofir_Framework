<?php

$URI = $_SERVER['REQUEST_URI'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($URI !== '/' && file_exists("public/{$URI}")) {
    return false;
}

require_once 'public/index.php';
