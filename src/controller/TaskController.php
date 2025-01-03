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

        public function showTasksView() {
            $tasks = $this->displayTasks();
            $tagsCategories = $this->displayTagsCategories();
            $assignedUsers = $this->displayAssignedUsers();
        
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
        
    }