<?php  
namespace Controller;
use Model\ProjectModel;
use Utilities\CSRF;

class ProjectController extends MainController {
    protected $MainController;
    protected $ProjectModel;

    public function __construct() {
        parent::__construct();
        $this->ProjectModel = new ProjectModel();
    }

    public function displayProjects() {
        $userId = $_SESSION["user_id"] ?? null;
        return $this->ProjectModel->getAllProjects($userId);
    }
    
    public function displayPendingRequests() {
        $userId = $_SESSION["user_id"] ?? null;
        $pendingRequests = $this->ProjectModel->getPendingRequests($userId);
        $getProjectsAssignedUsers = $this->ProjectModel->getProjectsAssignedUsers($userId);

        return [
            "pendingRequests" => $pendingRequests,
            "getProjectsAssignedUsers" => $getProjectsAssignedUsers
        ];
    }
    
    public function showProjectView() {
        $projects = $this->displayProjects();
        $pendingRequests = $this->displayPendingRequests();
    
        $viewData = [
            'projects' => $projects,
            'pendingRequests' => $pendingRequests
        ];
        extract($viewData);
        require_once __DIR__ . "/../view/projects.php";
    }
    

    public function addProject() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!isset($_POST["csrf_token"]) || !CSRF::validateToken("addProjectForm", $_POST["csrf_token"])) {
                die("Invalid CSRF Token");
            }

            $projectName = $_POST["project_name"] ?? '';
            $projectDesc = $_POST["project_description"] ?? '';
            $projectVisi = $_POST["isPublic"] ?? 0;
            $projectManager = $_POST["manager_id"] ?? '';
            $projectUsers = $_POST["project_users"] ?? [];

            if (empty($projectName) || empty($projectManager)) {
                header("Location: ?action=home&error=missing-required-fields");
                exit;
            }

            $data = [
                "name" => $projectName,
                "description" => $projectDesc,
                "isPublic" => $projectVisi,
                "manager_id" => $projectManager
            ];

            $projectId = $this->ProjectModel->create("project", $data);
            
            if($projectId) {
                $junctionData = [
                    ["project_id" => $projectId, "person_id" => $projectManager, "role" => "Member"],
                ];
                
                foreach($projectUsers as $userId) {
                    $junctionData[] = [
                        "project_id" => $projectId,
                        "person_id" => $userId,
                        "role" => "Member"
                    ];
                }
                
                $this->ProjectModel->create("Project_Assignment", $junctionData);
                header("Location: ?action=home&success=project-created");
                exit;
            } else {
                header("Location: ?action=home&error=project-creation-failed");
                exit;
            }
        }
    }

    public function approveRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $projectId = $_POST["project_id"] ?? null;
            $personId = $_POST["person_id"] ?? null;
            $managerId = $_SESSION["user_id"] ?? null;
            
            if (!$projectId || !$personId || !$managerId) {
                header("Location: ?action=home&error=missing-data");
                exit;
            }

            $project = $this->ProjectModel->read("project", ["id" => $projectId, "manager_id" => $managerId]);
            if (empty($project)) {
                header("Location: ?action=home&error=not-authorized");
                exit;
            }

            $success = $this->ProjectModel->updateProjectAssignment($projectId, $personId, "Member");
            
            if ($success) {
                header("Location: ?action=home&success=request-approved");
            } else {
                header("Location: ?action=home&error=approval-failed");
            }
            exit;
        }
    }

    public function disapproveRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $projectId = $_POST["project_id"] ?? null;
            $personId = $_POST["person_id"] ?? null;
            $managerId = $_SESSION["user_id"] ?? null;
            
            if (!$projectId || !$personId || !$managerId) {
                header("Location: ?action=home&error=missing-data");
                exit;
            }

            $project = $this->ProjectModel->read("project", ["id" => $projectId, "manager_id" => $managerId]);
            if (empty($project)) {
                header("Location: ?action=home&error=not-authorized");
                exit;
            }

            $success = $this->ProjectModel->deleteProjectAssignment($projectId, $personId);
            
            if ($success) {
                header("Location: ?action=home&success=request-denied");
            } else {
                header("Location: ?action=home&error=denial-failed");
            }
            exit;
        }
    }

    public function removeUserFromProject() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $projectId = $_POST["project_id"] ?? null;
            $personId = $_POST["person_id"] ?? null;
            $managerId = $_SESSION["user_id"] ?? null;
            
            if (!$projectId || !$personId || !$managerId) {
                header("Location: ?action=home&error=missing-data");
                exit;
            }

            $project = $this->ProjectModel->read("project", ["id" => $projectId, "manager_id" => $managerId]);
            if (empty($project)) {
                header("Location: ?action=home&error=not-authorized");
                exit;
            }

            if ($personId == $managerId) {
                header("Location: ?action=home&error=cannot-remove-manager");
                exit;
            }

            $success = $this->ProjectModel->deleteProjectAssignment($projectId, $personId);
            
            if ($success) {
                header("Location: ?action=home&success=user-removed");
            } else {
                header("Location: ?action=home&error=removal-failed");
            }
            exit;
        }
    }

    public function toggleVisibility() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $projectId = $_POST["project_id"] ?? null;
            $isPublic = $_POST["isPublic"] ?? null;
            $userId = $_SESSION["user_id"] ?? null;
            
            if (is_null($projectId) || is_null($isPublic) || is_null($userId)) {
                header("Location: ?action=home&error=missing-data");
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

    public function requestJoinProject() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $projectId = $_POST["project_id"] ?? null;
            $userId = $_SESSION["user_id"] ?? null;
            
            if (!$projectId || !$userId) {
                header("Location: ?action=home&error=missing-data");
                exit;
            }

            $existing = $this->ProjectModel->read("Project_Assignment", [
                "project_id" => $projectId,
                "person_id" => $userId
            ]);

            if (!empty($existing)) {
                header("Location: ?action=home&error=already-in-project");
                exit;
            }

            $data = [
                "project_id" => $projectId,
                "person_id" => $userId,
                "role" => "Pending Request"
            ];

            $success = $this->ProjectModel->create("Project_Assignment", $data);
            
            if ($success) {
                header("Location: ?action=home&success=request-sent");
            } else {
                header("Location: ?action=home&error=request-failed");
            }
            exit;
        }
    }
}