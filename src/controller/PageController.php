<?php
    namespace Controller;

    use Model\PermissionModel;
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
            $this->PermissionModel = new PermissionModel(); 
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

        public function roleManagment() {
            $roles = $this->PermissionModel->read('Role');
            $roleId = $_GET['id'] ?? null;
            $rolePermissions = [];
            $roleName = '';
        
            if ($roleId) {
                $role = $this->PermissionModel->read('Role', ['id' => $roleId]);
                $roleName = $role[0]['name'] ?? '';
        
                $rolePermissionsRaw = $this->PermissionModel->read('Role_Permission', ['role_id' => $roleId]);
                
                foreach ($rolePermissionsRaw as $perm) {
                    $rolePermissions[] = (int)$perm['permission_id']; 
                }
            }
        
            $permissions = $this->PermissionModel->read('Permission');
            $permissionIds = [];
            foreach ($permissions as $permission) {
                $permissionIds[$permission['name']] = (int)$permission['id']; 
            }
            require_once "../src/view/roleManagment.php";
        }
        
    }