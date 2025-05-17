<?php
define('BASE_PATH', dirname(__DIR__)); // Đường dẫn tới thư mục HotelManagement
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/configs');
define('CORE_PATH', BASE_PATH . '/core');
define('MODEL_PATH', APP_PATH . '/models');
define('CONTROLLER_PATH', APP_PATH . '/controllers');
define('VIEWS_PATH', APP_PATH . '/views');
define('PAGE_PATH', VIEWS_PATH . '/page');

$router = [
    'defaultController' => 'HomeController',
    'defaultAction' => 'index',
    'defaultParams' => []
];
