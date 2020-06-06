<?php

include ROOT."/models/LoginModel.php";

class LoginController {
    function main() {
        $view = new View();

        $view->render("login");
    }

    function check() {
        session_start();

        $userName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($userName) || empty($password)) {
            http_response_code(400);
            return;
        }

        $model = new LoginModel();
        $model->checkUser($userName, $password);

        return;
    }

    function logout() {
        session_start();
        unset($_SESSION['isAdmin']);

        header("Location: /tasks/1");
        die();
    }
}