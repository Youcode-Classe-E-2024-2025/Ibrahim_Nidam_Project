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
    }