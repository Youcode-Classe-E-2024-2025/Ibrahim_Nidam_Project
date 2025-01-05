<?php
    namespace Model;

    use PDO;

    class ProjectModel extends MainModel{
        private $table = "project";

        public function getAllProjects($userId){
            $sql = "
            SELECT DISTINCT p.*
            FROM project p
            LEFT JOIN Project_Assignment pa ON p.id = pa.project_id
            WHERE p.isPublic = 1 OR pa.person_id = :userId
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function recalcCompletion(){
            $projectId = $_GET["id"] ?? 0;

            $tasks = $this->read("task", ["project_id" => $projectId]);

            $doneCount = 0;
            $total = count($tasks);
            foreach($tasks as $t){
                if(!empty($t["status"]) && $t["status"] === "DONE"){
                    $doneCount++;
                }
            }

            $completion = 0;
            if($total > 0){
                $completion = round(($doneCount / $total) *100);
            }

            $this->update("project", ["completion_percentage" => $completion], ["id" => $projectId]);
        }
    }