<?php
    require "../vendor/autoload.php";
    use Controller\UserController;
    
    session_start();

    
    $action = $_GET["action"] ?? null;

    $validActions = ["login", "logout", "signup", "home"];

    if($action && !in_array($action, $validActions)){
        http_response_code(404);
        header("Location: ../src/view/sections/404.php");
        exit;
    }

    $action = $action ?? "login";

    $controller = null;
    
    switch($action) {
        case "login":
        case "signup":
            $controller = new UserController();
            $controller->$action();
            break;
        case "logout":
            $controller = new UserController();
            $controller->$action();
        default:
        http_response_code(404);
        header("Location: ../src/view/sections/404.php");
        exit;
    }