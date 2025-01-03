<?php
    namespace Model;

    use PDO;

    class TaskModel extends MainModel{
        private $table = "task";

        public function getAllTasks(){
            return $this->read($this->table, ["project_id" => $_GET["id"]]);
        }

        public function getTagsCategories(){
            $sql = "SELECT t.id AS task_id, c.name AS category_name, tg.name AS tag_name
                    FROM task t
                    INNER JOIN category c ON t.category_id = c.id
                    LEFT JOIN tag tg ON t.tag_id = tg.id
                    WHERE t.project_id = :project_id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(["project_id" => $_GET["id"]]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAssignedUsers(){
            $sql = "SELECT ta.task_id, p.name AS user_name
                    FROM task_assignment ta
                    INNER JOIN person p ON ta.person_id = p.id
                    WHERE ta.task_id IN (SELECT id FROM task WHERE project_id = :project_id)
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(["project_id" => $_GET["id"]]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
