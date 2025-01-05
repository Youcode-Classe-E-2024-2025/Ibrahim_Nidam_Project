<?php
    require "../vendor/autoload.php";

    use Controller\PageController;
    use Controller\ProjectController;
    use Controller\TaskController;
    use Controller\UserController;
    
    session_start();

    
    $action = $_GET["action"] ?? null;

    $validActions = ["login", "logout", "signup", "home", "addProject","kanban","addTask","toggleVisibility"];

    if($action && !in_array($action, $validActions)){
        http_response_code(404);
        header("Location: ../src/view/sections/404.php");
        exit;
    }

    // if(!in_array($action, ["login", "signup"]) && !isset($_SESSION["user"])){
    //     header("Location: index.php?action=login");
    //     exit;
    // }

    // if ($action === "login" && isset($_SESSION["user"])) {
    //     header("Location: index.php?action=home");
    //     exit;
    // }
    

    $action = $action ?? "login";

    $controller = null;
    
    switch($action) {
        case "login":
        case "signup":
            $controller = new UserController();
            $controller->$action();
            break;
        case "kanban":
            $controller = new TaskController();
            $controller->showTasksView();
            break;
        case "home":
            $controller = new PageController();
            $controller->$action();
            break;
        case "logout":
            $controller = new UserController();
            $controller->$action();
            break;
        case "addProject":
            $controller = new ProjectController();
            $controller->$action();
            break;
        case "addTask":
            $controller = new TaskController();
            $controller->$action();
            break;
        case "toggleVisibility":
            $controller = new ProjectController();
            $controller->$action();
            break;
        default:
            http_response_code(404);
            header("Location: ../src/view/sections/404.php");
            exit;
    }