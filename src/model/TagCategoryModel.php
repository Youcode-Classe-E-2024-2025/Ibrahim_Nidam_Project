<?php

    namespace Model;

    use PDO;

    class TagCategoryModel extends MainModel {
        private $catTable = "Category";
        private $tagTable = "Tag";
        private $junctionTable = "Project_Category_Tag";

        public function getAllCatsTags($projectId){
            
            $sql = "SELECT CATEGORY.id AS category_id, CATEGORY.name AS category_name,
                    TAG.id AS tag_id, TAG.name AS tag_name
                    FROM {$this->junctionTable} AS JUNCTION
                    LEFT JOIN {$this->catTable} AS CATEGORY ON JUNCTION.category_id = CATEGORY.id
                    LEFT JOIN {$this->tagTable} AS TAG ON JUNCTION.tag_id = TAG.id
                    WHERE JUNCTION.project_id = :project_id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":project_id", $projectId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }