<?php
    namespace Model;

    use PDO;

    class ProjectModel extends MainModel{
        private $table = "project";

        public function getAllProjects($userId) {
    $sql = "
        SELECT DISTINCT p.*, GROUP_CONCAT(pa.person_id) AS assigned_users
        FROM project p
        LEFT JOIN Project_Assignment pa ON p.id = pa.project_id
        WHERE p.isPublic = 1 OR pa.person_id = :userId OR p.manager_id = :userId
        GROUP BY p.id
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['userId' => $userId]);

    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert assigned_users from string to array
    foreach ($projects as &$project) {
        $project["assigned_users"] = $project["assigned_users"] ? explode(',', $project["assigned_users"]) : [];
    }

    return $projects;
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