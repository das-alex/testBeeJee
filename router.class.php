<?php

class Router {
    private $routes;

    function __construct() {
        $this->routes = [
            "/" => "Home"
        ];
    }

    function start() {
        $path = $_SERVER["REQUEST_URI"];

        foreach ($this->routes as $route => $controller) {
            if ($path === $route) {
                $this->getController($controller);
            }
        }

        header("HTTP/1.0 404 Not Found");
        return;
    }

    function getController($controller) {
        $controllerName = $controller."Controller";
        $controllerFile = ROOT."/controllers/".$controllerName.".php";

        if (file_exists($controllerFile)) {
            include($controllerFile);
        }

        if (!is_callable(array($controllerName, 'action'))) {
            header("HTTP/1.0 404 Not Found");
            return;
        }

        call_user_func_array(array($controllerName, 'action'), '');
    }
}