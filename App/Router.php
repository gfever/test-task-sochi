<?php
/**
 * @author d.ivaschenko
 */

namespace App;

use App\Helpers\Helper;

class Router
{
    private $controller;
    private $action;
    public function __construct()
    {
        $uri = (new Helper())->getUri();
        $routes = include __DIR__ . '/../config/routes.php';
        $route = '';
        if (!isset($routes[$uri])) {
            foreach ($routes as $key => $route) {
                if (0 === strpos($key, '{regex}')) {
                    $regex = explode($key, '}')[0];
                    if (preg_match("/{$regex}/uis", $uri)) {
                        break;
                    }
                }
            }
        } else {
            $route = $routes[$uri];
        }

        if (empty($route)) {
            header('404 Not Found');
            echo('404 Not found');
            exit;
        }

        [$this->controller, $this->action] = explode('@', $route);
        $this->controller = "\App\Controllers\\$this->controller";
        $this->controller = new $this->controller();
    }




    public function process(): void
    {
        try{
            $result = $this->controller->{$this->action}();
            foreach ($result['headers'] as $headerName => $info) {
                header("{$headerName}: {$info[0]}", $info[1]);
            }
            if (!empty($result['message'])) {
                echo($result['message']);
            }
        } catch (\Exception $e) {
            http_response_code($e->getCode());
        }

    }

}