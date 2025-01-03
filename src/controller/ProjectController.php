<?php   
    namespace Controller;

    use Model\ProjectModel;
    use Utilities\CSRF;

    class ProjectController extends MainController{
        protected $MainController;

        public function __construct(){
            $this->MainController = new MainController();
            $this->ProjectModel = new ProjectModel();
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

                    header("Location: ?action=home&success=true");
                    exit;
                } else {
                    header("Location: ?action=error=true");
                    exit;
                }
            }
        }
    }