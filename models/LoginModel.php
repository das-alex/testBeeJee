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
}