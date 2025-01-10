<?php
namespace Model;

class StatModel extends MainModel {

    // Get all tasks assigned to the user across all columns
    public function getUserTasks($userId) {
        $sql = "SELECT t.id, t.title, t.description, t.status, p.name AS project_name 
                FROM Task_Assignment ta
                JOIN Task t ON ta.task_id = t.id
                JOIN Project p ON t.project_id = p.id
                WHERE ta.person_id = :person_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['person_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Get all projects where the user is a member or the creator (manager)
    public function getUserProjects($userId) {
        $sql = "SELECT DISTINCT p.id, p.name, p.description, 
                    CASE WHEN p.manager_id = :person_id THEN 'Creator' ELSE 'Member' END AS role 
                FROM Project p
                LEFT JOIN Project_Assignment pa ON p.id = pa.project_id
                WHERE pa.person_id = :person_id OR p.manager_id = :person_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['person_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
