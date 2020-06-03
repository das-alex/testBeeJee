<?php

class HomeModel {
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

    function getPages() {
        $countTasksSql = "select count(task) as count from tasks where user_id <> 0";
        $qry = $this->pdo->query($countTasksSql);
        $count = $qry->fetch(PDO::FETCH_ASSOC);
        $count["countPages"] = ($count["count"] % 3 > 0 ? 1 : 0) + round($count["count"] / 3, PHP_ROUND_HALF_DOWN);

        return $count;
    }

    function getTasks($page) {
        session_start();

        if (isset($_SESSION["sorting"]) === false) {
            $_SESSION["sorting"] = [
                "field" => "tasks.id",
                "type" => "desc"
            ];
        }

        $offset = filter_var($page, FILTER_SANITIZE_NUMBER_INT) * 3 - 3;
        $sql = "select tasks.id, user_name, email, task, status ".
                "from tasks, users ".
                "where tasks.user_id = users.id ".
                "order by ".$_SESSION['sorting']['field']." ".$_SESSION['sorting']['type']." ".
                "limit 3 offset :offset";

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":offset", $offset, PDO::PARAM_INT);
        
        // Не работает (Если будет возможность, оставьте фидбэк по этому коду, пожалуйста)
        // $statement->bindParam(":orderBy", $_SESSION["sorting"]["field"]);
        // $statement->bindParam(":sort", $_SESSION["sorting"]["type"]);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    function addTask($userName, $email, $task) {
        $userId = $this->getUserId($userName, $email);
        
        if (!$userId) {
            $isUserAdded = $this->addUser($userName, $email);
            // $userId = $this-
        }
        
        $addTask = "insert into tasks (user_id, task, status) values (:userId, :task, 0)";
        $addTaskStmt = $this->pdo->prepare($addTask);
        $isAdded = $addTaskStmt->execute(array(
            ":userId" => intval($userId["id"]),
            ":task" => $task
        ));

        if (!$isAdded) {

        }

        $sql = "insert into tasks (user_id, task, status) values ()";
    }

    function getUserId($userName, $email) {
        $getUser = "select id from users where user_name = :userName and email = :email";

        $getUserStmt = $this->pdo->prepare($getUser);
        $getUserStmt->execute(array(
            ":userName" => $userName,
            ":email" => $email
        ));

        return $getUserStmt->fetch(PDO::FETCH_ASSOC);
    }

    function addUser($userName, $email) {
        $addUser = "insert into users (user_name, email, isAdmin) values (:userName, :email, 0)";
        $addUserStmt = $this->pdo->prepare($addUser);
        $isAdded = $addUserStmt->execute(array(
            ":userName" => $userName,
            ":email" => $email
        ));

        return $isAdded;
    }

    function sortBy($field, $type, $page) {
        session_start();

        if (!empty($field)) {
            $_SESSION["sorting"]["field"] = $field;
        }

        if (!empty($type)) {
            $_SESSION["sorting"]["type"] = $type;
        }

        $this->getTasks($page);
    }
}