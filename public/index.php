<?php
/**
 * @author d.ivaschenko
 */

require_once '../Autoloader.php';
Autoloader::register();

(new \App\Router(trim($_SERVER['REQUEST_URI'], '/')))->process();