<?php

class HomeController {
    function main($page) {
        $view = new View();
        $view->render("tasks", ["page" => $page]);
    }
}