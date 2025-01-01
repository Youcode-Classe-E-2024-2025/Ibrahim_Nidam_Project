<?php

    namespace Controller;

    use Connection\Database;
    use Model\UserModel;

    class MainController {
        protected $UserModel;

        public function __construct(){
            $this->UserModel = new UserModel();
        }
    }