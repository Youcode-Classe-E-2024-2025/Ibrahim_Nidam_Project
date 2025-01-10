<?php

    namespace Controller;

    use Connection\Database;
    use Model\PermissionModel;
    use Model\ProjectModel;
    use Model\TagCategoryModel;
    use Model\TaskModel;
    use Model\UserModel;

    class MainController {
        protected $UserModel;
        protected $ProjectModel;
        protected $TaskModel;
        protected $TagCategoryModel;
        protected $PermissionModel;

        public function __construct(){
            $this->UserModel = new UserModel();
            $this->ProjectModel = new ProjectModel();
            $this->TaskModel = new TaskModel();
            $this->TagCategoryModel = new TagCategoryModel();
            $this->PermissionModel = new PermissionModel();
        }
    }