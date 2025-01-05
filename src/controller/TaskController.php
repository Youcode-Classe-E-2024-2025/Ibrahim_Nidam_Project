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
                    AND p.role = 'Member'"
            ;
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

                    header("Location: ?action=kanban&id=$taskProj&name=$projeName");
                    exit;
                } else {
                    header("Location: ?action=error=true");
                    exit;
                }


            }
        }
        
    }