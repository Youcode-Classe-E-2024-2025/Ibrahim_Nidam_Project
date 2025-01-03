<?php
    namespace Controller;

    // use Controller\ProjectController;
    class PageController extends MainController {
        protected $ProjectController;
        protected $UserController;

        public function __construct(){
            $this->ProjectController = new ProjectController();
            $this->UserController = new UserController();
        }

        public function home(){
            $projects = $this->ProjectController->displayProjects();
            $users = $this->UserController->displayUsers();
            require_once "../src/view/projects.php";
        }

        public function kanban(){
            require_once "../src/view/kanban.php";
        }
    }