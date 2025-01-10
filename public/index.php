<?php
    require "../vendor/autoload.php";

    use Controller\PageController;
    use Controller\ProjectController;
    use Controller\TagCategoryController;
    use Controller\TaskController;
    use Controller\UserController;
    use Controller\PermissionController;
    use Controller\StatController;

    session_start();
    
    $action = $_GET["action"] ?? null;

    $validActions = ["login","userData","exportStats","deleteRole","updateRole", "logout", "signup","createRole", "home","roleManagment","permissions","updatePermission","deletePermission","createPermission", "dashboard", "addProject","kanban","addTask","toggleVisibility", "updateTaskStatus", "TagsAndCategories", "addTagOrCategory", "approveRequest", "disapproveRequest", "removeUserFromProject"];

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
        case "updateTaskStatus":
            $controller = new TaskController();
            $controller->$action();
            break;
        case "dashboard":
            $controller = new PageController();
            $controller->$action();
            break;
        case "TagsAndCategories":
            $controller = new PageController();
            $controller->$action();
            break;
        case "addTagOrCategory":
            $controller = new TagCategoryController();
            $controller->$action();
            break;
        case "approveRequest":
        case "disapproveRequest":
        case "removeUserFromProject":
            $controller = new ProjectController();
            $controller->$action();
            break;
        case "roleManagment":
            $controller = new PageController();
            $controller->$action();
            break;
        case "permissions":
            $controller = new PermissionController();
            $controller->$action();
            break;
        case "createPermission":
            $controller = new PermissionController();
            $controller->$action();
            break;
        case "deletePermission":
            $controller = new PermissionController();
            $controller->$action($_GET["id"] ?? null);
            break;
        case "updatePermission":
            $controller = new PermissionController();
            $controller->$action();
            break;
        case "createRole":
            $controller = new PermissionController();
            $controller->$action();
            break;
        case "deleteRole":
            $controller = new PermissionController();
            $controller->$action($_GET["id"] ?? null);
            break;
        case "updateRole":
            $controller = new PermissionController();
            $controller->updateRole($_GET["id"] ?? null);
            break;
        case "userData":
            $controller = new StatController();
            $controller->getUserData($_SESSION['user_id']);
            break;
        case "exportStats":
            $controller = new StatController();
            $controller->exportUserStats($_SESSION['user_id']);
            break;
        default:
            http_response_code(404);
            header("Location: ../src/view/sections/404.php");
            exit;
    }