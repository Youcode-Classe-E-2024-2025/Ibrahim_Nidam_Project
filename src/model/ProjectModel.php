<?php
    namespace Model;

    use PDO;

    class ProjectModel extends MainModel{
        private $table = "project";
        private $pendingTable = "Project_Assignment";

        public function getAllProjects($userId) {
            $sql = "SELECT DISTINCT p.*, GROUP_CONCAT(pa.person_id) AS assigned_users
                    FROM project p
                    LEFT JOIN Project_Assignment pa ON p.id = pa.project_id
                    WHERE p.isPublic = 1 OR pa.person_id = :userId OR p.manager_id = :userId
                    GROUP BY p.id
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['userId' => $userId]);

            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($projects as &$project) {
                $project["assigned_users"] = $project["assigned_users"] ? explode(',', $project["assigned_users"]) : [];
            }

            return $projects;
        }

        public function updateProjectAssignment($projectId, $personId, $role) {
            $sql = "UPDATE project_assignment 
                    SET role = :role 
                    WHERE project_id = :project_id 
                    AND person_id = :person_id";
                    
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                "role" => $role,
                "project_id" => $projectId,
                "person_id" => $personId
            ]);
        }
        
        public function deleteProjectAssignment($projectId, $personId) {
            return $this->delete("project_assignment", [
                "project_id" => $projectId,
                "person_id" => $personId
            ]);
        }
        
        public function getAssignedProjects($userId) {
            $sql = "SELECT p.*, pa.role
                    FROM project p
                    INNER JOIN project_assignment pa ON p.id = pa.project_id
                    WHERE pa.person_id = :userId";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["userId" => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPendingRequests($userId) {
            $sql = "SELECT PROA.project_id, PROJECT.name AS project_name, 
                    PERSON.name AS user_name, PROA.person_id, PROA.role
                    FROM project_assignment PROA
                    INNER JOIN project PROJECT ON PROA.project_id = PROJECT.id
                    INNER JOIN person PERSON ON PROA.person_id = PERSON.id
                    WHERE PROJECT.manager_id = :manager_id 
                    AND PROA.role = 'Pending Request'";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["manager_id" => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function getProjectsAssignedUsers($userId) {
            $sql = "SELECT PROA.project_id, PROJECT.name AS project_name, 
                    PERSON.name AS user_name, PROA.person_id, PROA.role
                    FROM project_assignment PROA
                    INNER JOIN project PROJECT ON PROA.project_id = PROJECT.id
                    INNER JOIN person PERSON ON PROA.person_id = PERSON.id
                    WHERE PROJECT.manager_id = :manager_id 
                    AND PROA.role = 'Member'";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["manager_id" => $userId]);
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

            $this->update($this->table, ["completion_percentage" => $completion], ["id" => $projectId]);
        }
    }