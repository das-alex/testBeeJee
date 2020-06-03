<?php

include ROOT."/models/HomeModel.php";

class HomeController {
    function main($page) {
        $view = new View();
        $model = new HomeModel();

        // add validation for these vars
        $result = $model->getTasks($page);
        $countPages = $model->getPages();

        $view->render("tasks", [
            "page" => $page,
            "tasks" => $result,
            "countPages" => $countPages
        ]);
    }

    function add() {
        $userName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$email || $userName === "" || $task === "") {
            http_response_code(400);
            return;
        }

        $model = new HomeModel();
        $model->addTask($userName, $email, $task);

        return;
    }

    function sort($sortBy) {
        $field = filter_input(INPUT_GET, 'field', FILTER_SANITIZE_SPECIAL_CHARS);
        $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($field) && empty($type)) {
            http_response_code(400);
            return;
        }

        $model = new HomeModel();
        $model->sortBy($field, $type, $page);

        return;
    }
}