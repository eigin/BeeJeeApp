<?php
session_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$path = __DIR__ . '/../backend/controller/Router.php';
require_once $path;

// старт маршрутизатора
Router::start();
