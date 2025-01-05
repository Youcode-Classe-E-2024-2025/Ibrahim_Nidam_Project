<?php
    namespace Controller;

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

        public function showTasksView($categories = [], $tags = [], $availableUsers = []) {
            $tasks = $this->displayTasks();
            $tagsCategories = $this->displayTagsCategories();
            $assignedUsers = $this->displayAssignedUsers();
            
            $sql = "SELECT id, name FROM category";
            $categories = $this->TaskModel->query($sql);

            $sql = "SELECT id, name FROM tag";
            $tags = $this->TaskModel->query($sql);

            $sql = "SELECT DISTINCT p.id as person_id, p.name AS user_name 
                    FROM Person p 
                    INNER JOIN Project_Assignment pa ON p.id = pa.person_id 
                    WHERE pa.project_id = :project_id 
                    AND p.role = 'Member'"
            ;
            $availableUsers = $this->TaskModel->query($sql, ["project_id" => $_GET["id"]]);

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
            $sql = "SELECT DISTINCT c.id, c.name AS name
                    FROM category c
                    WHERE c.project_id = :project_id
            ";

            $categories = $this->TaskModel->query($sql, ["project_id" => $_GET["id"]]);

            $sql = "SELECT DISTINCT t.id, t.name AS name
                    FROM tag t
                    WHERE t.project_id = :project_id
            ";

            $tags = $this->TaskModel->query($sql, ["project_id" => $_GET["id"]]);

            $sql = "SELECT p.id AS person_id, p.name AS user_name
                    FROM person p
                    INNER JOIN project_member pm ON p.id = pm.person_id
                    WHERE pm.project_id = :project_id
            ";

            $availableUsers = $this->TaskModel->query($sql, ["project_id" => $_GET["id"]]);

            $this->showTasksView($categories, $tags, $availableUsers);
        }
        
    }