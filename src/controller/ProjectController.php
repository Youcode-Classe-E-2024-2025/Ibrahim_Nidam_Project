<?php   
    namespace Controller;

    use Model\ProjectModel;
    use Utilities\CSRF;

    class ProjectController extends MainController{
        protected $MainController;


        public function displayProjects(){
            $userId = $_SESSION["user_id"] ?? null;
            return $this->ProjectModel->getAllProjects($userId);
        }

        public function showProjectView(){
            $projects = $this->displayProjects();
            require_once __DIR__ . "/../view/projects.php";
        }
        
        public function addProject(){
            
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if(!isset($_POST["csrf_token"]) || !CSRF::validateToken("addProjectForm",$_POST["csrf_token"])){
                    die("Invalid CSRF Token");
                }

                $projectName = $_POST["project_name"];
                $projectDesc = $_POST["project_description"];
                $projectVisi = $_POST["isPublic"];
                $projectManager = $_POST["manager_id"];
                $projectUsers = $_POST["project_users"] ?? [];

                $data = [
                    "name" => $projectName,
                    "description" => $projectDesc,
                    "isPublic" => $projectVisi,
                    "manager_id" => $projectManager
                ];

                $projectId = $this->ProjectModel->create("project", $data);

                if($projectId){
                    $junctionData= [
                        ["project_id" => $projectId, "person_id" => $projectManager],
                    ]; 

                    foreach($projectUsers as $userId){
                        $junctionData[] = ["project_id" => $projectId, "person_id" => $userId];
                    }

                    $this->ProjectModel->create("Project_Assignment", $junctionData);

                    header("Location: ?action=home");
                    exit;
                } else {
                    header("Location: ?action=error=true");
                    exit;
                }
            }
        }

        public function toggleVisibility(){
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $projectId = $_POST["project_id"] ?? null;
                $isPublic = $_POST["isPublic"] ?? null;
                $userId = $_SESSION["user_id"] ?? null;

                if (is_null($projectId) || is_null($isPublic) || is_null($userId)) {
                    header("Location: ?action=home&error=missing-data&projId=$projectId&isPublic=$isPublic&userId=$userId");
                    exit;
                }

                if (is_null($userId)) { 
                    header("Location: ?action=home&error=guest-action-not-allowed");
                    exit;
                }

                $project = $this->ProjectModel->read("project", ["id" => $projectId])[0] ?? null;

                if (!$project || $project["manager_id"] != $userId) {
                    header("Location: ?action=home&error=not-authorized");
                    exit;
                }

                $this->ProjectModel->update("project", ["isPublic" => $isPublic], ["id" => $projectId]);
                header("Location: ?action=home&success=visibility-updated");
                exit;
            }
        }

    }