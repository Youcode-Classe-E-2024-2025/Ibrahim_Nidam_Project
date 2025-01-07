<?php
    namespace Controller;

use Utilities\CSRF;

    class TaskController extends MainController {
        

        public function displayTasks(){
            return $this->TaskModel->getAllTasks();
        }

        public function displayTagsCategories(){
            return $this->TaskModel->getTagsCategories();
        }

        public function displayAssignedUsers(){
            return $this->TaskModel->getAssignedUsers();
        }

        public function showTasksView() {
            $tasks = $this->displayTasks();
            $tagsCategories = $this->displayTagsCategories();
            $assignedUsers = $this->displayAssignedUsers();

            $formData = $this->populateTaskForm();
            $categories = $formData["categories"];
            $tags = $formData["tags"];
            $availableUsers = $formData["availableUsers"];

            $projectId = (int) $_GET["id"];
            $projectResult = $this->TaskModel->read("project", ["id" => $projectId]);
            $project = $projectResult[0] ?? null;
            
            foreach ($tasks as &$task) {
                $task["category_name"] = "Unknown Category";
                $task["tag_name"] = "General";
                $task["assigned_users"] = [];
        
                foreach ($tagsCategories as $tc) {
                    if (isset($tc["task_id"]) && $tc["task_id"] === $task["id"]) {
                        $task["category_name"] = $tc["category_name"] ?? "Unknown Category";
                        $task["tag_name"] = $tc["tag_name"] ?? "General";
                        break;
                    }
                }
        
                foreach ($assignedUsers as $au) {
                    if (isset($au["task_id"]) && $au["task_id"] === $task["id"]) {
                        $task["assigned_users"][] = $au["user_name"] ?? "Unknown User";
                    }
                }
            }
        
            require_once __DIR__ . "/../view/kanban.php";
        }

        public function populateTaskForm(){
            
            $table = "category";
            $categories = $this->TaskModel->read($table);

            $table = "tag";
            $tags = $this->TaskModel->read($table);

            $sql = "SELECT DISTINCT p.id as person_id, p.name AS user_name 
                    FROM Person p 
                    INNER JOIN Project_Assignment pa ON p.id = pa.person_id 
                    WHERE pa.project_id = :project_id
                    AND p.role = 'Project Manager'
            ";
            
            $availableUsers = $this->TaskModel->query($sql, ["project_id" => $_GET["id"]]);

            return ["categories" => $categories,
                    "tags" => $tags,
                    "availableUsers" => $availableUsers
            ];
        }

        public function addTask(){
            
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                if(!isset($_POST["csrf_token"]) || !CSRF::validateToken("addTask", $_POST["csrf_token"])){
                    die("Invalid CSRF Token");
                }
                $projeName= $_GET["name"];
                $taskName = $_POST["title"];
                $taskDesc = $_POST["description"];
                $taskProj = $_GET["id"];
                $taskCate = $_POST["category_id"];
                $taskTag = $_POST["tag_id"] === "" ? null : $_POST["tag_id"];
                $taskUsers = $_POST["assigned_users"] ?? [];

                $data = [
                    "title" => $taskName,
                    "description" => $taskDesc,
                    "category_id" =>  $taskCate,
                    "tag_id" => $taskTag,
                    "project_id" => $taskProj,
                ];

                $taskId = $this->TaskModel->create("task", $data);
                
                if($taskId){
                    foreach($taskUsers as $userId){
                        $junctionData[] = ["task_id" => $taskId, "person_id" =>$userId];
                    }

                    $this->TaskModel->create("task_assignment", $junctionData);
                    $this->ProjectModel->recalcCompletion($taskProj);

                    header("Location: ?action=kanban&id=$taskProj&name=$projeName");
                    exit;
                } else {
                    header("Location: ?action=error=true");
                    exit;
                }
            }
        }

        public function updateTaskStatus(){

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $taskId   = $_POST["task_id"] ?? null;
                $newStatus = $_POST["new_status"] ?? null;
                $userId   = $_SESSION["user_id"] ?? null;
                $userName = $_SESSION["user_name"] ?? null;
                $projectId = (int) $_GET["id"];

                if (!$taskId || !$newStatus || !$userId) {
                    header("Location: ?action=kanban&id=$projectId&error=missing-data");
                    exit;
                }

                $task = $this->TaskModel->read("task", ["id" => $taskId]);
                if (empty($task)) {
                    header("Location: ?action=kanban&id=$projectId&error=TaskNotFound");
                    exit;
                }
                $task = $task[0];

                $project = $this->TaskModel->read("project", ["id" => $projectId]);
                if (empty($project)) {
                    header("Location: ?action=kanban&id=$projectId&error=NoProject");
                    exit;
                }
                $project = $project[0];
                $projectManagerId = $project["manager_id"];

                $assignedUsers = array_column($this->TaskModel->getAssignedUserByTask($taskId), "user_name");
                $isAssigned = in_array($userName, $assignedUsers);

                $isManager = ($projectManagerId == $userId);

                if (!$isManager && !$isAssigned) {
                    header("Location: ?action=kanban&id=$projectId&error=Unauthorized");
                    exit;
                }

                $this->TaskModel->update("task", ["status" => $newStatus], ["id" => $taskId]);
                $this->ProjectModel->recalcCompletion($projectId);

                header("Location: ?action=kanban&id=$projectId&success=status-updated");
                exit;
            }
        }

        
    }