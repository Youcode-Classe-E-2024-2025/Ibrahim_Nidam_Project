<?php
    namespace Controller;

    class PageController extends MainController {
        protected $MainController;

        public function __construct(){
            $this->MainController = new MainController();
        }

        public function home(){
            $projects = $this->MainController->displayProjects();
            $users = $this->MainController->displayUsers();
            require_once "../src/view/projects.php";
        }
    }