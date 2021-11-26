<?php
use core\Autoloader;

try {
    ini_set('display_errors', 0);
    ini_set('file_uploads', 1);
    error_reporting(E_ALL);
    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    require_once (ROOT . 'core/Autoloader.php');
    Autoloader::register();
} catch (Exception $e){
    echo 'error';
}