<?php
use core\Autoloader;
use core\App;

try {
    ini_set('display_errors', 0);
    ini_set('file_uploads', 1);
    error_reporting(E_ALL);

    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    require_once (ROOT . 'core/Autoloader.php');
    $config = require ROOT . 'config/config.php';
    Autoloader::register();
    App::start($config);
} catch (Exception $e){
    echo 'error';
}