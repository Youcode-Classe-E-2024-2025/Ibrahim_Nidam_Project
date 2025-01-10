<?php
    namespace Controller;

    use Model\TagCategoryModel;

    // use Controller\ProjectController;
    class PageController extends MainController {
        protected $ProjectController;
        protected $UserController;
        protected $TagCategoryController;

        public function __construct(){
            $this->ProjectController = new ProjectController();
            $this->UserController = new UserController();
            $this->TagCategoryModel = new TagCategoryModel();   
        }

        public function home(){
            $projects = $this->ProjectController->displayProjects();
            $users = $this->UserController->displayUsers();
            $pendingData = $this->ProjectController->displayPendingRequests();
    
            $viewData = [
                'projects' => $projects,
                'users' => $users,
                'pendingRequests' => $pendingData
            ];
    
            extract($viewData);
            require_once "../src/view/projects.php";
        }

        public function kanban(){
            require_once "../src/view/kanban.php";
        }

        public function dashboard(){
            require_once "../src/view/dashboard.php";
        }

        public function TagsAndCategories(){
            $projectId = $_GET["project_id"];
            $tagsAndCategs = $this->TagCategoryModel->getAllCatsTags($projectId);
            require_once "../src/view/tags_cats.php";
        }

        public function roleManagment(){
            require_once "../src/view/roleManagment.php";
        }
    }