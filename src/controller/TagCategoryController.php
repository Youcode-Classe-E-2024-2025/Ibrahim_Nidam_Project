<?php
    namespace Controller;

    class TagCategoryController extends MainController {
        private $catTable = "Category";
        private $tagTable = "Tag";
        private $junctionTable = "Project_Category_Tag";

        public function addTagOrCategory(){
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $projectId = $_GET["project_id"];
                $projectName = $_GET["name"];
                
                if(isset($_POST["tag"])){
                    $newTag = $_POST["tag"];

                    $tagId = $this->TagCategoryModel->create($this->tagTable,["name" => $newTag]);
    
                    if($tagId){
    
                        $data = [
                            "project_id" => $projectId,
                            "tag_id" => $tagId
                        ];
                        
                        $this->TagCategoryModel->create($this->junctionTable,$data);

                    } else {
                        header("Location: ?action=error=true");
                        exit;
                    }
                }

                if(isset($_POST["category"])){
                    $newCat = $_POST["category"];

                    $catId = $this->TagCategoryModel->create($this->catTable, ["name" => $newCat]);

                    if($catId){

                        $data = [
                            "project_id" => $projectId,
                            "category_id" => $catId
                        ];

                        $this->TagCategoryModel->create($this->junctionTable, $data);

                    } else {
                        header("Location: ?action=error=true");
                        exit;
                    }
                }

                header("Location: ?action=TagsAndCategories&project_id=" . $projectId . "&name=" . urlencode($projectName));
                exit;
            }
        }
    }