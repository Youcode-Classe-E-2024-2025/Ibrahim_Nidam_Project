<?php

    namespace Controller;

    use Connection\Database;
    use Model\ProjectModel;
    use Model\UserModel;

    class MainController {
        protected $UserModel;
        protected $ProjectModel;

        public function __construct(){
            $this->UserModel = new UserModel();
            $this->ProjectModel = new ProjectModel();
        }

        public function displayProjects(){
            return $this->ProjectModel->getAllProjects();
        }

        public function showProjectView(){
            $projects = $this->displayProjects();
            require_once __DIR__ . "/../view/projects.php";
        }

        public function displayUsers(){
            return $this->UserModel->getAllUsers();
        }

        public function showUsersView(){
            $users = $this->displayUsers();
            require_once __DIR__ . "/../view/projects.php";
        }
    }