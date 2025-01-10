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
            $projectId = $_GET["id"];
        
            $sql = "SELECT c.id, c.name FROM category c
                    INNER JOIN Project_Category_Tag pct ON c.id = pct.category_id
                    WHERE pct.project_id = :project_id";
            $categories = $this->TaskModel->query($sql, ["project_id" => $projectId]);
        
            $sql = "SELECT tg.id, tg.name FROM tag tg
                    INNER JOIN Project_Category_Tag pct ON tg.id = pct.tag_id
                    WHERE pct.project_id = :project_id";
            $tags = $this->TaskModel->query($sql, ["project_id" => $projectId]);
        
            $sql = "SELECT DISTINCT p.id as person_id, p.name AS user_name 
                    FROM Person p 
                    INNER JOIN Project_Assignment pa ON p.id = pa.person_id 
                    WHERE pa.project_id = :project_id
                    AND p.role = 'Project Manager'";
            $availableUsers = $this->TaskModel->query($sql, ["project_id" => $projectId]);
        
            return [
                "categories" => $categories,
                "tags" => $tags,
                "availableUsers" => $availableUsers
            ];
        }
        

        public function addTask() {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (!isset($_POST["csrf_token"]) || !\Utilities\CSRF::validateToken("addTask", $_POST["csrf_token"])) {
                    die("Invalid CSRF Token");
                }
        
                $projeName = $_GET["name"];
                $taskName = $_POST["title"] ?? null;
                $taskDesc = $_POST["description"] ?? null;
                $taskProj = $_GET["id"] ?? null;
                $taskCate = $_POST["category_id"] ?? null;
                $taskTag = $_POST["tag_id"] === "" ? null : $_POST["tag_id"];
                $taskUsers = $_POST["assigned_users"] ?? [];
        
                if (!$taskName || !$taskProj || !$taskCate) {
                    die("Error: Missing title, project, or category.");
                }
        
                $projectCategoryTagId = $this->TaskModel->ensureProjectCategoryTag($taskProj, $taskCate, $taskTag);
        
                if (!$projectCategoryTagId) {
                    die("Error: Failed to create Project Category Tag relationship.");
                }
        
                $data = [
                    "title" => $taskName,
                    "description" => $taskDesc,
                    "category_id" => $taskCate,
                    "tag_id" => $taskTag,
                    "project_id" => $taskProj,
                    "project_category_tag_id" => $projectCategoryTagId
                ];
        
                $taskId = $this->TaskModel->create("task", $data);
        
                if ($taskId) {
                    $junctionData = [];
                    foreach ($taskUsers as $userId) {
                        $junctionData[] = ["task_id" => $taskId, "person_id" => $userId];
                    }
        
                    $this->TaskModel->create("task_assignment", $junctionData);
                    $this->ProjectModel->recalcCompletion($taskProj);
        
                    header("Location: ?action=kanban&id=$taskProj&name=$projeName");
                    exit;
                } else {
                    die("Error: Failed to add task.");
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