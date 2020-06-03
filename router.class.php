<?php

class Router {
    private $routes;
    
    function __construct() {
        // url path => internal route
        $this->routes = [
            "login" => "login/main",
            "tasks/([-_0-9]+)" => "home/main/$1",
            "tasks/add" => "home/add",
            "tasks/sort/([-_a-z]+)" => "home/sort/$1"
        ];
    }

    function start() {
        $url = trim($_SERVER["REQUEST_URI"], "/");

        foreach ($this->routes as $route => $internal) {
            if (preg_match("~$route~", $url)) {
                $internalParts = explode("/", preg_replace("~$route~", $internal, $url));
                
                $controller = ucfirst(array_shift($internalParts));
                $action = array_shift($internalParts);
                $params = $internalParts;

                $this->getController($controller, $action, $params);
            }
        }

        return;
    }

    function getController($controller, $action, $params) {
        $controllerName = $controller."Controller";
        $controllerFile = ROOT."/controllers/".$controllerName.".php";

        if (file_exists($controllerFile)) {
            include($controllerFile);
        }

        if (!is_callable(array($controllerName, $action))) {
            header("HTTP/1.0 404 Not Found");
            return;
        }

        include(ROOT."/views/View.php");
        call_user_func_array(array($controllerName, $action), $params);
    }
}