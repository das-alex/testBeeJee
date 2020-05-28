<?php

class Controller {
    protected $view;

    function __construct() {
        include(ROOT."/views/View.php");

        $this->view = new View();
    }
}