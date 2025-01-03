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
    }