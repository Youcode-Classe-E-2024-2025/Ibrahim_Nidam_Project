<?php

    namespace Controller;

    use Connection\Database;
    use Model\ProjectModel;
    use Model\TaskModel;
    use Model\UserModel;

    class MainController {
        protected $UserModel;
        protected $ProjectModel;
        protected $TaskModel;

        public function __construct(){
            $this->UserModel = new UserModel();
            $this->ProjectModel = new ProjectModel();
            $this->TaskModel = new TaskModel();
        }
    }