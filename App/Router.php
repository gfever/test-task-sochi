<?php
/**
 * @author d.ivaschenko
 */

namespace App;


use App\Controllers\UrlController;

class Router
{

    private $uri;
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }


    public function getParams()
    {
        $exploded = explode('?', $this->uri);
        $route = $exploded[0];
        $params = [];
        if (isset($exploded[1])) {
            parse_str($exploded[1], $params);
        }

        return compact('route', 'params');
    }

    public function process()
    {
        $data = $this->getParams();
        $controller = new UrlController();

        if ($data['route'] === 'create') {
            return $controller->create(@$data['params']['url']);
        }

        if (empty($data['params']) && \strlen($data['route']) === 5) {
            $controller->redirect($data['route']);
        }
    }

}