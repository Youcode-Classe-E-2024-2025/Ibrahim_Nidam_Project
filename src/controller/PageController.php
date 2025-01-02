<?php
    namespace Controller;

    class PageController extends MainController {
        protected $MainController;

        public function __construct(){
            $this->MainController = new MainController();
        }

        public function home(){
            $projects = $this->MainController->displayProjects();
            require_once "../src/view/projects.php";
        }
    }