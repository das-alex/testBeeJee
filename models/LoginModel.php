<?php

class LoginModel {
    private $pdo;

    function __construct() {
        $this->pdo = $this->getConnection();
    }

    function getConnection() {
        try {
            // For docker container host must be the name of the container
            return new PDO('mysql:host=testbeejee_db_1;dbname=beejee', 'admin', 'password');
        } catch (Exception $error) {
            return [
                "error" => $error->getMessage()
            ];
        }
    }

    function checkUser($userName, $password) {
        $isPasswordRight = $this->pdo->prepare("select password from users where isAdmin=1 and user_name=:userName");
        $isPasswordRight->bindParam(":userName", $userName, PDO::PARAM_STR);
        $isPasswordRight->execute();
        $res = $isPasswordRight->fetch(PDO::FETCH_ASSOC);

        if ($res === false || !password_verify($password, $res["password"])) {
            http_response_code(400);
            return;
        }

        session_start();
        $_SESSION["isAdmin"] = true;

        return;
    }
}